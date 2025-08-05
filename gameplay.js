/**
 * Core gameplay logic for Empire
 */

// ====== 1. PARAMÈTRES DE BASE ======
const MAX_CITY_LEVEL = 50;
const MAX_BUILDING_LEVEL = 50;
const START_RESOURCES = { wood: 500, marble: 0, wine: 0, crystal: 0, sulfur: 0, gold: 2000 };
const START_CITY = {
    level: 1,
    population: 50,
    happiness: 50,
    minesLevel: 1,
    buildings: {},
    buildQueue: [],
    unitQueue: [],
    shipQueue: [],
    wallDefense: 0,
    units: []
};
const START_TECH = [];
const START_UNITS = [];
const START_NAVY = [];

// ====== 2. PROGRESSION DU JOUEUR ======
let player = {
    level: 1,
    xp: 0,
    cities: [START_CITY],
    resources: { ...START_RESOURCES },
    research: START_TECH,
    units: START_UNITS,
    navy: START_NAVY,
    government: "Ikacratie"
};

// ====== 3. RESSOURCES ======
function produceResources(city) {
    let base = 5; // unités/h
    let bonusMines = (city.minesLevel || 0) * 2;
    let bonusResearch = player.research.includes("Optimisation") ? 2 : 0;
    return base + bonusMines + bonusResearch;
}

function subtractResources(stock, cost) {
    let res = { ...stock };
    for (let [k, v] of Object.entries(cost)) {
        res[k] = (res[k] || 0) - v;
    }
    return res;
}

function multiplyResources(cost, count) {
    return Object.fromEntries(Object.entries(cost).map(([k, v]) => [k, v * count]));
}

// ====== 4. BÂTIMENTS ET AMÉLIORATIONS ======
const BUILDINGS = {
    townHall: { baseCost: { wood: 500 }, baseTime: 3600, effect: lvl => ({ popMax: 50 + lvl * 30 }) },
    warehouse: { baseCost: { wood: 200 }, baseTime: 1800, effect: lvl => ({ storage: 500 + lvl * 500 }) },
    academy: { baseCost: { wood: 500, crystal: 300 }, baseTime: 3600, effect: lvl => ({ researchPoints: lvl * 5 }) },
    tavern: { baseCost: { wood: 300 }, baseTime: 2400, effect: lvl => ({ happiness: lvl * 12 }) },
    museum: { baseCost: { wood: 500, marble: 200 }, baseTime: 3600, effect: lvl => ({ happiness: lvl * 20 }) },
    port: { baseCost: { wood: 600 }, baseTime: 4200, effect: lvl => ({ shipSlots: lvl }) },
    barracks: { baseCost: { wood: 800, sulfur: 300 }, baseTime: 4800, effect: lvl => ({ recruitSpeed: 1 - lvl * 0.02 }) },
    wall: { baseCost: { wood: 500, marble: 400 }, baseTime: 7200, effect: lvl => ({ defense: lvl * 15 }) }
};

function upgradeBuilding(city, type) {
    let b = BUILDINGS[type];
    let lvl = city.buildings[type] || 0;
    let cost = Object.fromEntries(Object.entries(b.baseCost).map(([res, val]) => [res, Math.ceil(val * Math.pow(1.5, lvl))]));
    let time = b.baseTime * Math.pow(1.3, lvl);
    player.resources = subtractResources(player.resources, cost);
    city.buildQueue.push({ type, endTime: Date.now() + time });
}

// ====== 5. RECHERCHES ======
const RESEARCH_TREE = {
    economy: [
        { name: "Optimisation", cost: 500, effect: () => { player.resourcesProduction = (player.resourcesProduction || 0) + 2; } },
        { name: "Expansion", cost: 1000, effect: () => { player.maxCities = (player.maxCities || 1) + 1; } }
    ],
    military: [
        { name: "Tactiques avancées", cost: 800, effect: () => { player.unitAttackBonus = (player.unitAttackBonus || 0) + 5; } },
        { name: "Catapultes", cost: 1200, effect: () => { player.unitsUnlocked = [...(player.unitsUnlocked || []), "catapult"]; } }
    ],
    science: [
        { name: "Philosophie", cost: 600, effect: () => { player.researchSpeed = (player.researchSpeed || 0) + 0.1; } },
        { name: "Bibliothèque", cost: 1000, effect: () => { player.researchPoints = (player.researchPoints || 0) + 10; } }
    ],
    navigation: [
        { name: "Routes commerciales", cost: 900, effect: () => { player.tradeRoutes = (player.tradeRoutes || 0) + 1; } },
        { name: "Navires rapides", cost: 1100, effect: () => { player.shipSpeed = (player.shipSpeed || 1) + 0.2; } }
    ]
};

function researchTech(branch, index) {
    let tech = RESEARCH_TREE[branch][index];
    if (!player.research.includes(tech.name) && player.resources.crystal >= tech.cost) {
        player.resources.crystal -= tech.cost;
        player.research.push(tech.name);
        tech.effect();
    }
}

// ====== 6. ARMÉE ======
const UNITS = {
    hoplite: { cost: { wood: 50, sulfur: 30 }, upkeep: 3, attack: 10, defense: 20, buildTime: 600 },
    archer: { cost: { wood: 30 }, upkeep: 2, attack: 8, defense: 10, buildTime: 400 },
    catapult: { cost: { wood: 200, sulfur: 100 }, upkeep: 5, attack: 50, defense: 10, buildTime: 1800 }
};

function recruitUnit(city, type, count) {
    let u = UNITS[type];
    let totalCost = multiplyResources(u.cost, count);
    player.resources = subtractResources(player.resources, totalCost);
    city.unitQueue.push({ type, count, endTime: Date.now() + u.buildTime * count });
}

// ====== 7. NAVIRES ======
const SHIPS = {
    transport: { cost: { wood: 300 }, capacity: 500, buildTime: 1200 },
    ram: { cost: { wood: 500, sulfur: 200 }, attack: 25, buildTime: 2400 },
    mortarShip: { cost: { wood: 700, sulfur: 400 }, attack: 60, buildTime: 3600 }
};

function buildShip(city, type, count) {
    let s = SHIPS[type];
    let totalCost = multiplyResources(s.cost, count);
    player.resources = subtractResources(player.resources, totalCost);
    city.shipQueue.push({ type, count, endTime: Date.now() + s.buildTime * count });
}

// ====== 8. COMBAT ======
function sumAttack(units) {
    return units.reduce((acc, u) => acc + (UNITS[u.type]?.attack || 0) * u.count, 0);
}

function sumDefense(units) {
    return units.reduce((acc, u) => acc + (UNITS[u.type]?.defense || 0) * u.count, 0);
}

function calculateLoot(attacker, defender) {
    const loot = {};
    for (let [res, amt] of Object.entries(defender.resources || {})) {
        loot[res] = Math.floor(amt * 0.5);
    }
    return loot;
}

function calculateBattle(attacker, defender) {
    let atkPower = sumAttack(attacker.units);
    let defPower = sumDefense(defender.units) + (defender.wallDefense || 0);
    let winner = atkPower > defPower ? "attacker" : "defender";
    return { winner, loot: calculateLoot(attacker, defender) };
}

// ====== 9. NIVEAU JOUEUR ======
function addXP(amount) {
    player.xp += amount;
    let needed = player.level * 1000;
    if (player.xp >= needed) {
        player.level++;
        player.xp -= needed;
    }
}

// ====== 10. BOUCLE DE JEU ======
setInterval(() => {
    for (let city of player.cities) {
        let production = produceResources(city);
        player.resources.wood += production;
        player.resources.gold += city.population * 0.1;
    }
}, 3600000); // chaque heure

