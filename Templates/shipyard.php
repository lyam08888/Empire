<?php
if(!isset($_SESSION['sessid']))
	header("Location: ../index.php");
$building = new CBuilding;
?>
<link href="css/common.css" rel="stylesheet" type="text/css" media="screen">
<link href="css/shipyard.css" rel="stylesheet" type="text/css" media="screen">
<?php include("js/js1.php");?>
</head>
<body id="shipyard" dir="rtl">
 <div id="container">
  <div id="container2">
   <div id="header">
    <h1>إيكارياما empire</h1>
    <h2>عش في العصور القديمة!</h2>
   </div>
   <div id="avatarNotes"></div>
   <div id="breadcrumbs">
    <h3>أنت هنا:</h3>
    <a href="?view=worldmap_iso&amp;islandX=<?php echo $city->x;?>&amp;islandY=<?php echo $city->y;?>" title="عودة إلى خارطة العالم">
    <img src="img/resource/icon-world.gif" alt="عالم" />
    </a>
    <span>&nbsp;&gt;&nbsp;</span>
    <a href="?view=island&amp;id=<?php echo $city->iid;?>" title="عودة إلى الجزيرة">
    <img src="img/resource/icon-island.gif" alt="<?php echo $island->name?>" /><?php echo $island->name?>[<?php echo $city->x;?>:<?php echo $city->y;?>]</a>
    <span>&nbsp;&gt;&nbsp;</span>
    <a href="?view=city&amp;id=<?php echo $city->cid;?>" class="city" title="عودة إلى المدينة"><?php echo $city->cname;?></a>
    <span>&nbsp;&gt;&nbsp;</span>
    <span class="building">حوض بناء السفن الحربية</span>
   </div>
   <div id="buildingUpgrade" class="dynamic">
    <h3 class="header">تطوير
    <a class="help" href="?view=buildingDetail&buildingId=6" title="مساعدة"><span class="textLabel">هل تحتاج لمساعدة؟</span>
    </a>
    </h3>
    <div class="content">
     <div class="buildingLevel">
      <span class="textLabel">مستوى </span>
      <?php echo $building->currentLevel;?>
     </div><?php if($building->currentLevel<18){?>
     <h4>ضروري للمستوى <?php echo $building->getBuildingNextLevel($_GET["position"]);?>:</h4>
     <ul class="resources">
     <?php if($building->nextLevelRes["wood"] != 0){?>
      <li class="wood" title="مادة صناعية"><span class="textLabel">مادة صناعية: </span><?php echo number_format($building->nextLevelRes["wood"]);?>
      </li>
      <?php }if($building->nextLevelRes["marble"] != 0){?>
	  <li class="marble alt" title="رخام"><span class="textLabel">رخام: </span><?php echo number_format($building->nextLevelRes["marble"]);?>
      </li>
     <?php }?> 
      <li class="time" title="وقت البناء"><span class="textLabel">وقت البناء: </span>
	  <?php 
	  $time = $generator->getTimeFormat($building->nextLevelRes["time"]);
	  if($time["d"]) echo $time["d"]."يوم ";
	  if($time["h"] && $time["d"]) echo $time["h"]."س ";
	  else if($time["h"]) echo $time["h"]."ساعة ";
	  if($time["m"] && $time["h"]) echo $time["m"]."د ";
	  else if($time["m"]) echo $time["m"]."دقيقة ";
	  if($time["s"]) echo $time["s"]."ث ";
	  ?>
      </li>
      </ul>
      <ul class="actions">
      <li class="upgrade">
  <?php if(($ships->GetShipsBuildingListNbr()==0)&&($building->currentLevel<18)&&$building->canBuild()&&$building->checkResource(2,$building->currentLevel+1)){?>    
      <a href="?action=CityScreen&function=upgradeBuilding&id=<?php echo $city->cid;?>&position=<?php echo $_GET["position"]?>&level=<?php echo $building->currentLevel;?>&actionRequest=<?php echo $session->checker;?>" title="في لائحة البناء!">
      <span class="textLabel">تحسين</span>
      </a>
  <?php }else{?>
      <a class="disabled" href="#" title="إكمال الإنشاء غير ممكن حالياً"></a>
  <?php }?>
      </li>
      <li class="downgrade">
   <?php if(($ships->GetShipsBuildingListNbr()==0)&& !$building->AmIUpgrading($_GET["position"]) && ($building->currentLevel > 1)){?>   
      <a href="?view=buildings_demolition&id=<?php echo $city->cid;?>&position=<?php echo $_GET["position"]?>&actionRequest=<?php echo $session->checker;?>" title="تدمير المبنى"><span class="textLabel">تدمير</span></a>
   <?php }else{?>
      <a class="disabled" href="#" title="التدمير غير ممكن حالياً!"></a>
   <?php }?>
      </li>
      </ul><?php }?> </div>
    <div class="footer"></div>
   </div>
   <div class="dynamic" id="reportInboxLeft">
    <h3 class="header">تفتيش الموقع العسكري</h3>
    <div class="content">
     <div class="centerButton">
     <a href="?view=fleetGarrisonEdit&id=552932&position=2" class="button">طرد وحدات</a>
     </div>
    </div>
    <div class="footer"></div>
   </div>
   <div id="unitConstructionList" class="dynamic">
    <h3 class="header">لائحة بناء 
    <a class="help" href="?view=shipdescription&shipId=210" title="مساعدة">
    <span class="textLabel">مساعدة</span></a>
    </h3>
    <div class="content">
<?php if($ships->GetShipsBuildingListNbr()!=0){?>
   <h4 style="">جاري البناء:</h4>
 <?php for($s=210; $s<217; $s++){?>
  <?php if($ships->ShipsInBuildNbr(0,$s)){?>
   <div class="army_wrapper" title="<?php echo $ships->GetShipInfo("$s","name");?>">
    <div class="army ship s<?php echo $s;?>">
     <span class="textLabel"><?php echo $ships->GetShipInfo("$s","name");?>: </span>
     <div class="unitcounttextlabel"><?php echo $ships->ShipsInBuildNbr(0,"$s");?></div>
    </div>
   </div>
 <?php }}?>  
   <div style="clear:both;"></div>
   <div class="results" style="">
    <div class="progressbar">
     <div class="bar" id="buildProgress" title="<?php echo $ships->GetUBListPercent2Finish(0);?>%" style="width:<?php echo $ships->GetUBListPercent2Finish(0);?>%;">
     </div>
    </div>
    <div class="time" id="buildCountDown">
     <?php $time = $generator->getTimeFormat($ships->GetUBListTime(0)-time());
	  if($time["d"]) echo $time["d"]."يوم ";
	  if($time["h"] && $time["d"]) echo $time["h"]."س ";
	  else if($time["h"]) echo $time["h"]."ساعة ";
	  if($time["m"] && $time["h"]) echo $time["m"]."د ";
	  else if($time["m"]) echo $time["m"]."دقيقة ";
	  if($time["s"]) echo $time["s"]."ث ";
	  ?>
     <span class="textLabel"> حتى الإنتهاء</span>
    </div>
   </div>
   <div class="buttonAbort first">
    <a class="button" href="javascript:myConfirm('هل أنت متأكد من قرارك بإلغاء عمل البناء؟ سيتسبب هذا في ضياع كل المواد الأولية المستثمرة!','?action=CityScreen&function=abortMilitaryConstruction&id=<?php echo $city->cid;?>&actionRequest=<?php echo $session->checker;?>&position=<?php echo $_GET['position'];?>&eid=<?php echo $ships->GetUBListID(0);?>&type=fleet');">إلغاء</a>
   </div>
   <!---------------------->
 <?php if($ships->GetShipsBuildingListNbr()>1){?>
   <div class="constructionBlock">
    <h4 style="">في صف الانتظار (1):</h4>
 <?php for($s=210; $s<217; $s++){?>
  <?php if($ships->ShipsInBuildNbr(1,$s)){?>
    <div class="army_wrapper" title="<?php echo $ships->GetShipInfo("$s","name");?>">
     <div class="army ship s<?php echo $s;?>">
      <span class="textLabel"><?php echo $ships->GetShipInfo("$s","name");?>: </span>
      <div class="unitcounttextlabel"><?php echo $ships->ShipsInBuildNbr(1,"$s");?></div>
     </div>
    </div>
    <div style="clear:both;"></div>
 <?php }}?> 
    <div class="constructionBlock">
     <div class="time" id="queueEntry2"   style="">
      <?php $time = $generator->getTimeFormat($ships->GetUBListTime(1)-time());
	  if($time["d"]) echo $time["d"]."يوم ";
	  if($time["h"] && $time["d"]) echo $time["h"]."س ";
	  else if($time["h"]) echo $time["h"]."ساعة ";
	  if($time["m"] && $time["h"]) echo $time["m"]."د ";
	  else if($time["m"]) echo $time["m"]."دقيقة ";
	  if($time["s"]) echo $time["s"]."ث ";
	  ?>
      <span class="textLabel"> حتى الإنتهاء</span>
     </div>
    </div>
    <div class="buttonAbort">
     <a class="button" href="javascript:myConfirm('هل أنت متأكد من قرارك بإلغاء عمل البناء؟ سيتسبب هذا في ضياع كل المواد الأولية المستثمرة!','?action=CityScreen&function=abortMilitaryConstruction&id=<?php echo $city->cid;?>&actionRequest=<?php echo $session->checker;?>&position=<?php echo $_GET['position'];?>&eid=<?php echo $ships->GetUBListID(0);?>&type=fleet');">إلغاء</a>
    </div>
   </div>
 <?php }?>
 <?php if($ships->GetShipsBuildingListNbr()>2){?>
   <div class="constructionBlock">
    <h4 style="">في صف الانتظار (2):</h4>
 <?php for($s=210; $s<217; $s++){?>
  <?php if($ships->ShipsInBuildNbr(2,$s)){?>
    <div class="army_wrapper" title="<?php echo $ships->GetShipInfo("$s","name");?>">
     <div class="army ship s<?php echo $s;?>">
      <span class="textLabel"><?php echo $ships->GetShipInfo("$s","name");?>: </span>
      <div class="unitcounttextlabel"><?php echo $ships->ShipsInBuildNbr(2,"$s");?></div>
     </div>
    </div>
    <div style="clear:both;"></div>
 <?php }}?> 
    <div class="constructionBlock">
     <div class="time" id="queueEntry2"   style="">
      <?php $time = $generator->getTimeFormat($ships->GetUBListTime(2)-time());
	  if($time["d"]) echo $time["d"]."يوم ";
	  if($time["h"] && $time["d"]) echo $time["h"]."س ";
	  else if($time["h"]) echo $time["h"]."ساعة ";
	  if($time["m"] && $time["h"]) echo $time["m"]."د ";
	  else if($time["m"]) echo $time["m"]."دقيقة ";
	  if($time["s"]) echo $time["s"]."ث ";
	  ?>
      <span class="textLabel"> حتى الإنتهاء</span>
     </div>
    </div>
    <div class="buttonAbort">
     <a class="button" href="javascript:myConfirm('هل أنت متأكد من قرارك بإلغاء عمل البناء؟ سيتسبب هذا في ضياع كل المواد الأولية المستثمرة!','?action=CityScreen&function=abortMilitaryConstruction&id=<?php echo $city->cid;?>&actionRequest=<?php echo $session->checker;?>&position=<?php echo $_GET['position'];?>&eid=<?php echo $ships->GetUBListID(0);?>&type=fleet');">إلغاء</a>
    </div>
   </div>
 <?php }?>
<?php }?>
    </div>
    <div class="footer"></div>
   </div>
   <div id="mainview">
    <div class="buildingDescription">
     <h1>حوض بناء السفن الحربية</h1>
<?php if($building->AmIUpgrading($_GET["position"])){?> 
 <div id="upgradeInProgress">
  <div class="buildingLevel">
   <span class="textLabel">مستوى </span>
   <?php echo $building->currentLevel;?>
  </div>
  <div class="nextLevel">
   <span class="textLabel">المستوى التالي </span>
   <?php echo $building->currentLevel+1;?>
  </div>
  <div class="isUpgrading">جاري إكمال الإنشاء</div>
  <div class="progressBar">
   <div class="bar" id="upgradeProgress" title="<?php echo $building->GetBUpPercent2Finish();?>%" style="width:<?php echo $building->GetBUpPercent2Finish();?>%;">
   </div>
  </div>
  <a class="cancelUpgrade" href="?view=buildings_demolition&id=<?php echo $city->cid;?>&position=<?php echo $_GET["position"];?>&actionRequest=<?php echo $session->checker;?>" title="إلغاء"><span class="textLabel">إلغاء</span>
  </a>
  <script type="text/javascript">
  Event.onDOMReady(function() {
   var tmppbar = getProgressBar({
   startdate: <?php echo $building->GetBUpgradingStartTime();?>,
   enddate: <?php echo $building->GetBUpgradingTime();?>,
   currentdate: <?php echo time();?>,
   bar: "upgradeProgress"});
   tmppbar.subscribe("update", function(){
    this.barEl.title=this.progress+"%";});
   tmppbar.subscribe("finished", function(){
    this.barEl.title="100%";});
	});
   </script>
   <div class="time" id="upgradeCountDown">
    <?php $time = $generator->getTimeFormat($building->GetBUpgradingTime()-time());
	  if($time["d"]) echo $time["d"]."يوم ";
	  if($time["h"] && $time["d"]) echo $time["h"]."س ";
	  else if($time["h"]) echo $time["h"]."ساعة ";
	  if($time["m"] && $time["h"]) echo $time["m"]."د ";
	  else if($time["m"]) echo $time["m"]."دقيقة ";
	  if($time["s"]) echo $time["s"]."ث ";
	  ?>
   </div>
   <script type="text/javascript">
   Event.onDOMReady(function() {
    var tmpCnt = getCountdown({
	 enddate: <?php echo $building->GetBUpgradingTime();?>,
	 currentdate: <?php echo time();?>,
	 el: "upgradeCountDown"}, 2, " ", "", true, true);
	 tmpCnt.subscribe("finished", function() {
	 setTimeout(function() {
	  location.href="?view=barraks&id=<?php echo $city->cid;?>&position=<?php echo $_GET["position"];?>";
	 },2000);
	 });
	});
   </script>
 </div>
<?php }?>  
     <p>ما الفائدة من إمبراطورية جزيرة من دون أسطولها؟ في حوض بناء السفن الحربية يتم الدفع بالسفن إلى الماء وتحضيرها للقيام برحلات طويلة. فلترتجف منها البحار السبعة!

أحواض بناء السفن الأكبر يمكنها إعداد السفن بشكل أسرع.</p>
    </div>
    <form id="buildForm"  action="action.php" method="POST">
     <input type=hidden name="action" value="CityScreen">
     <input type=hidden name="function" value="buildShips">
     <input type="hidden" name="actionRequest" value="<?php echo $session->checker;?>" />
     <input type=hidden name="id" value="<?php echo $city->cid;?>">
     <input type=hidden name="position" value="<?php echo $_GET['position'];?>">
     <div class="contentBox01h" id="selected_units">
      <h3 class="header">الوحدات المُختارة لتلقي التكوين</h3>
      <div class="content">
       <div id="unitCountIcons">&nbsp;</div>
       <div class="divider"></div>
       <div id="cost_wrapper">
        <span id="accumulatedUnitCosts">&nbsp;</span>
        <span id="button_purchase"><input class="button" type="submit" id="button_recruit" value="جنّد"></span>
       </div>
      </div>
      <div class="footer">&nbsp;</div>
     </div>
     <div class="contentBox01h">
       <h3 class="header">تدريب الوحدات</h3>
       <div class="content">
        <ul id="units">
<?php for($s=210; $s<217; $s++){?>  
  <?php if($ships->IsShipBuildingAvailable($s)){ 
        $shipyardCond = $ships->ShipyardLevelCond("$s");
  ?>       
         <li class="unit <?php echo $ships->GetShipHTMLClass($s);?>">
          <div class="unitinfo">
           <h4><?php echo $ships->getShipInfo("$s","name");?></h4>
           <a title="إلى وصف الـ <?php echo $ships->getShipInfo("$s","name");?>" href="?view=unitdescription&unitId=315">
           <img src="img/characters/fleet/120x100/<?php echo $ships->GetShipHTMLClass($s);?>_r_120x100.gif" />
           </a>
           <div class="unitcount">
            <span class="textLabel">متوفر: </span>
            <?php echo $ships->GetShipsNbr("$s");?> 
           </div>
           <p><?php echo $ships->getShipInfo("$s","desc");?></p>
          </div>
          <label for="textfield_<?php echo $ships->GetShipHTMLClass($s);?>">تدريب <?php echo $ships->getShipInfo("$s","name");?></label>
          <div class="sliderinput">
           <div class="sliderbg" id="sliderbg_<?php echo $ships->GetShipHTMLClass($s);?>">
            <div class="actualValue" id="actualValue_<?php echo $ships->GetShipHTMLClass($s);?>"></div>
            <div class="sliderthumb" id="sliderthumb_<?php echo $ships->GetShipHTMLClass($s);?>"></div>
           </div>
           <script type="text/javascript">
		   create_slider({
		   	dir : 'rtl',
			id : "slider_<?php echo $ships->GetShipHTMLClass($s);?>",
			maxValue : <?php echo $ships->GetMaxShipMaxNbr("$s");?>,
			overcharge : 0,
			iniValue : 0,
			bg : "sliderbg_<?php echo $ships->GetShipHTMLClass($s);?>",
			thumb : "sliderthumb_<?php echo $ships->GetShipHTMLClass($s);?>",
			topConstraint: -10,
			bottomConstraint: 326,
			bg_value : "actualValue_<?php echo $ships->GetShipHTMLClass($s);?>",
			textfield:"textfield_<?php echo $ships->GetShipHTMLClass($s);?>"
		   });
		   var slider = sliders["default"];
		   </script>
           <a class="setMin" href="#reset" onClick="sliders['slider_<?php echo $ships->GetShipHTMLClass($s);?>'].setActualValue(0); return false;" title="إعادة الإدخال للبداية">
           <span class="textLabel">أدنى</span>
           </a>
           <a class="setMax" href="#max" onClick="sliders['slider_<?php echo $ships->GetShipHTMLClass($s);?>'].setActualValue(<?php echo $ships->GetMaxShipMaxNbr("$s");?>); return false;" title="تدريب أكبر عدد ممكن">
           <span class="textLabel">أقصى</span>
           </a>
          </div>
          <?php if($shipyardCond){?>
          <div class="forminput">
           <input class="textfield" id="textfield_<?php echo $ships->GetShipHTMLClass($s);?>" type="text" name="<?php echo $s?>"  value="0" size="4" maxlength="4">
           <a class="setMax" href="#max" onClick="sliders['slider_<?php echo $ships->GetShipHTMLClass($s);?>'].setActualValue(<?php echo $ships->GetMaxShipMaxNbr("$s");?>); return false;" title="تدريب أكبر عدد ممكن">
           <span class="textLabel">أقصى</span>
           </a>
          </div>
          <?php }else{?>
          <div class="forminput">
           <span class="textLabel">مستوى المبنى غير كافي!!</span>
          </div>
          <?php }?>
          <div class="costs">
           <h5>تكاليف:</h5>
           <ul class="resources">
           <li class="citizens" title="مواطنون">
            <span class="textLabel">مواطنون: </span>
           <?php echo $ships->getShipInfo("$s","citizens");?>
           </li>
           <li class="wood" title="مادة صناعية">
            <span class="textLabel">مادة صناعية: </span>
            <?php echo $ships->getShipInfo("$s","wood");?>
           </li>
           <?php if($ships->getShipInfo("$s","sulfur")){?>
           <li class="sulfur" title="كبريت">
            <span class="textLabel">كبريت: </span>
            <?php echo $ships->getShipInfo("$s","sulfur");?>
           </li>
           <?php }?>
           <?php if($ships->getShipInfo("$s","crystal")){?>
           <li class="crystal" title="كبريت">
            <span class="textLabel">بلور: </span>
            <?php echo $ships->getShipInfo("$s","crystal");?>
           </li>
           <?php }?>
           <li class="upkeep" title="تكاليف التأمين في الساعة">
            <span class="textLabel">تكاليف التأمين في الساعة: </span>
            <?php echo $ships->getShipInfo("$s","upkeep");?>
           </li>
           <li class="time" title="وقت البناء">
           <span class="textLabel">وقت البناء: </span>
           <?php $time = $generator->getTimeFormat($ships->getShipInfo("$s","time")-($ships->getShipInfo("$s","time")*($building->currentLevel-1)*3/100));
	  echo $time["m"]."د ";
	  if($time["s"]) echo $time["s"]."ث ";
	  ?>
           </li>
           </ul>
          </div>
         </li>
 <?php }?> 
<?php }?>
        </ul>
       </div>
       <div class="footer"></div>
     </div>
    </form><!-- End buildForm -->
   </div><!-- END mainview -->
   
<?php include("citynavigator.php");?>
<?php include("footer.php");?>
<?php include("toolbar.php");?>
 </div>
</div>
<?php include("js/js2.php");?>
<?php if($ships->GetShipsBuildingListNbr()!=0){?>
<script type="text/javascript">
    getCountdown({
        enddate: <?php echo $ships->GetUBListTime(0);?>,
        currentdate: <?php echo time();?>,
        el: "buildCountDown"
        }, 2, " ", "", true, true);
    var tmppbar = getProgressBar({
        startdate: <?php echo $ships->GetUBListStartTime(0);?>,
        enddate: <?php echo $ships->GetUBListTime(0);?>,
        currentdate: <?php echo time();?>,
        bar: "buildProgress"
        });

    tmppbar.subscribe("update", function(){
        this.barEl.title=this.progress+"%";
        });
    tmppbar.subscribe("finished", function(){
        this.barEl.title="100%";
        });
</script>
<?php }?>
<script type="text/javascript">
 Event.onDOMReady(function() {
  var cCC = new constructionCostController({  
  availableResourcesAtCity: availableResourcesAtCity,
  localData: localData,
  unitIconsDiv:'unitCountIcons',
  unitCostsDiv:'accumulatedUnitCosts',
  noUnitsSelectedText:'لم يتم اختيار أي وحدات بعد',
  rowLength: 14,
  button_recruit : 'button_recruit',
  unitCategory : '111'
 });
<?php for($s=210; $s<217; $s++){?>
  <?php if($ships->IsShipBuildingAvailable($s)){?> 
cCC.registerInput(
sliders['slider_<?php echo $ships->GetShipHTMLClass($s)?>'],
{citizens:<?php echo $ships->getShipInfo("$s","citizens");?>,
wood:<?php echo $ships->getShipInfo("$s","wood");?>,
<?php if($ships->getShipInfo("$s","sulfur")>0){?>
	sulfur:<?php echo $ships->getShipInfo("$s","sulfur");?>,
<?php }if($ships->getShipInfo("$s","crystal")>0){?>
	crystal:<?php echo $ships->getShipInfo("$s","crystal");?>,
<?php }if($ships->getShipInfo("$s","wine")>0){?>
	wine:<?php echo $ships->getShipInfo("$s","wine");?>,
<?php }?>
upkeep:<?php echo $ships->getShipInfo("$s","upkeep");?>,
completiontime:<?php echo $ships->getShipInfo("$s","time");?>},
'<?php echo $s;?>',
'<?php echo $ships->getShipInfo("$s","name");?>',
'<?php echo $ships->GetShipHTMLClass($s)?>');
<?php }}?>  
cCC.displayNoUnitsHTML();
cCC.sumTotalCosts();
cCC.updateTotalCostsHTML();
});
availableResourcesAtCity = {
   'citizens':<?php echo $city->citizens;?>,
   'wood':<?php echo $city->awood;?>,
   'wine':<?php echo $city->awine;?>,
   'marble':<?php echo $city->amarble;?>,
   'crystal':<?php echo $city->acrystal;?>,
   'sulfur':<?php echo $city->asulfur;?>};
localData = {
'citizens': { 'langKey': 'مواطنون', 'className': 'citizens' },
'wood': { 'langKey': 'مادة صناعية', 'className': 'wood' },
'wine': { 'langKey': 'مشروب العنب', 'className': 'wine' },
/*'marble': { 'langKey': 'رخام', 'className': 'marble' },*/
'crystal': { 'langKey': 'بلور', 'className': 'crystal' },
'sulfur': { 'langKey': 'كبريت', 'className': 'sulfur' },
'upkeep': { 'langKey': 'تكاليف التأمين في الساعة', 'className': 'upkeep' },
'completiontime': { 'langKey': 'وقت البناء', 'className': 'time' } };
</script>