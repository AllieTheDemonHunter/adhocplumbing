<SCRIPT LANGUAGE="JavaScript">
function setOptions(chosen) 
{ 
	var selbox = document.form1.tyresize; 
	var selbox2 = document.form1.speedindex; 
	selbox.options.length = 0; 
	selbox2.options.length = 0; 
	if (chosen == " ") { 
		selbox.options[selbox.options.length] = new Option('Please select one of the options above first',' '); 
		selbox2.options[selbox2.options.length] = new Option('Please select one of the options above first',' '); 
	} 
	if (chosen == "Anakee 2") { 
		selbox.options[selbox.options.length] = new Option('100/90-19','100/90-19');
		selbox.options[selbox.options.length] = new Option('110/80R19','110/80R19');
		selbox.options[selbox.options.length] = new Option('90/90-21','90/90-21');
		selbox2.options[selbox2.options.length] = new Option('H','H');
		selbox2.options[selbox2.options.length] = new Option('V','V');
	} 
	if (chosen == "Commander 2") { 
		selbox.options[selbox.options.length] = new Option('100/90B19','100/90B19');
		selbox.options[selbox.options.length] = new Option('130/80-17','130/80-17');
		selbox.options[selbox.options.length] = new Option('130/90-16','130/90-16');
		selbox.options[selbox.options.length] = new Option('80/90-21','80/90-21');
		selbox2.options[selbox2.options.length] = new Option('H','H');
	} 
	if (chosen == "Pilot Activ") { 
		selbox.options[selbox.options.length] = new Option('100/90-18','100/90-18');
		selbox.options[selbox.options.length] = new Option('100/90-19','100/90-19');
		selbox.options[selbox.options.length] = new Option('110/70-17','110/70-17');
		selbox.options[selbox.options.length] = new Option('110/80-17','110/80-17');
		selbox.options[selbox.options.length] = new Option('110/80-18','110/80-18');
		selbox.options[selbox.options.length] = new Option('110/90-18','110/90-18');
		selbox.options[selbox.options.length] = new Option('120/70-17','120/70-17');
		selbox.options[selbox.options.length] = new Option('120/80-16','120/80-16');
		selbox.options[selbox.options.length] = new Option('120/90-18','120/90-18');
		selbox.options[selbox.options.length] = new Option('3.25-19','3.25-19');
		selbox2.options[selbox2.options.length] = new Option('H','H');
		selbox2.options[selbox2.options.length] = new Option('V','V');
	} 
	if (chosen == "Pilot Power 2CT") { 
		selbox.options[selbox.options.length] = new Option('120/70 ZR 17 ','120/70 ZR 17 ');
		selbox2.options[selbox2.options.length] = new Option('W','W');
	} 
	if (chosen == "Pilot Road") { 
		selbox.options[selbox.options.length] = new Option('120/70ZR17','120/70ZR17');
		selbox2.options[selbox2.options.length] = new Option('W','W');
	} 
	if (chosen == "Pilot Road 2") { 
		selbox.options[selbox.options.length] = new Option('120/70ZR17','120/70ZR17');
		selbox2.options[selbox2.options.length] = new Option('W','W');
	} 
	if (chosen == "Pilot Road 3") { 
		selbox.options[selbox.options.length] = new Option('110/80R19','110/80R19');
		selbox.options[selbox.options.length] = new Option('110/80ZR18','110/80ZR18');
		selbox.options[selbox.options.length] = new Option('120/60ZR17','120/60ZR17');
		selbox.options[selbox.options.length] = new Option('120/70ZR17','120/70ZR17');
		selbox.options[selbox.options.length] = new Option('120/70ZR18','120/70ZR18');
		selbox2.options[selbox2.options.length] = new Option('V','V');
		selbox2.options[selbox2.options.length] = new Option('W','W');
	} 
	if (chosen == "Power Cup") { 
		selbox.options[selbox.options.length] = new Option('120/70R17','120/70R17');
		selbox.options[selbox.options.length] = new Option('120/70ZR17','120/70ZR17');
		selbox2.options[selbox2.options.length] = new Option('V','V');
		selbox2.options[selbox2.options.length] = new Option('W','W');
	} 
	if (chosen == "Power Pure") { 
		selbox.options[selbox.options.length] = new Option('120/70ZR17','120/70ZR17');
		selbox2.options[selbox2.options.length] = new Option('W','W');
	} 
} 
function setOptions2(chosen2) 
{ 
	var selbox3 = document.form1.tyresize2; 
	var selbox4 = document.form1.speedindex2; 
	selbox3.options.length = 0; 
	selbox4.options.length = 0; 
	if (chosen2 == " ") { 
		selbox3.options[selbox3.options.length] = new Option('Please select one of the options above first',' '); 
		selbox4.options[selbox4.options.length] = new Option('Please select one of the options above first',' '); 
	} 
	if (chosen2 == "Anakee 2") { 
		selbox3.options[selbox3.options.length] = new Option('130/80 R17 ','130/80 R17 ');
		selbox3.options[selbox3.options.length] = new Option('140/80 R17 ','140/80 R17 ');
		selbox3.options[selbox3.options.length] = new Option('150/70 R17','150/70 R17');
		selbox4.options[selbox4.options.length] = new Option('H','H');
		selbox4.options[selbox4.options.length] = new Option('V','V');
	} 
	if (chosen2 == "Commander 2") { 
		selbox3.options[selbox3.options.length] = new Option('150/80-16','150/80-16');
		selbox3.options[selbox3.options.length] = new Option('150/90-15','150/90-15');
		selbox3.options[selbox3.options.length] = new Option('160/70-17','160/70-17');
		selbox3.options[selbox3.options.length] = new Option('170/80-15','170/80-15');
		selbox3.options[selbox3.options.length] = new Option('180/65-16','180/65-16');
		selbox3.options[selbox3.options.length] = new Option('200/55-17','200/55-17');
		selbox4.options[selbox4.options.length] = new Option('H','H');
		selbox4.options[selbox4.options.length] = new Option('V','V');
	} 
	if (chosen2 == "Pilot Activ") { 
		selbox3.options[selbox3.options.length] = new Option('120/90-18','120/90-18');
		selbox3.options[selbox3.options.length] = new Option('130/70-17','130/70-17');
		selbox3.options[selbox3.options.length] = new Option('130/80-17','130/80-17');
		selbox3.options[selbox3.options.length] = new Option('130/80-18','130/80-18');
		selbox3.options[selbox3.options.length] = new Option('130/90-17','130/90-17');
		selbox3.options[selbox3.options.length] = new Option('140/70-17','140/70-17');
		selbox3.options[selbox3.options.length] = new Option('150/70-17','150/70-17');
		selbox4.options[selbox4.options.length] = new Option('H','H');
		selbox4.options[selbox4.options.length] = new Option('V','V');
	} 
	if (chosen2 == "Pilot Power 2CT") { 
		selbox3.options[selbox3.options.length] = new Option('180/55ZR17','180/55ZR17');
		selbox3.options[selbox3.options.length] = new Option('190/50ZR17','190/50ZR17');
		selbox3.options[selbox3.options.length] = new Option('190/55ZR17','190/55ZR17');
		selbox4.options[selbox4.options.length] = new Option('W','W');
	} 
	if (chosen2 == "Pilot Road") { 
		selbox3.options[selbox3.options.length] = new Option('180/55ZR17','180/55ZR17');
		selbox3.options[selbox3.options.length] = new Option('190/50ZR17','190/50ZR17');
		selbox4.options[selbox4.options.length] = new Option('W','W');
	} 
	if (chosen2 == "Pilot Road 2") { 
		selbox3.options[selbox3.options.length] = new Option('180/55ZR17','180/55ZR17');
		selbox3.options[selbox3.options.length] = new Option('190/50ZR17','190/50ZR17');
		selbox4.options[selbox4.options.length] = new Option('W','W');
	} 
	if (chosen2 == "Pilot Road 3") { 
		selbox3.options[selbox3.options.length] = new Option('150/70R17','150/70R17');
		selbox3.options[selbox3.options.length] = new Option('150/70ZR17','150/70ZR17');
		selbox3.options[selbox3.options.length] = new Option('160/60ZR17','160/60ZR17');
		selbox3.options[selbox3.options.length] = new Option('160/60ZR18','160/60ZR18');
		selbox3.options[selbox3.options.length] = new Option('180/55ZR17','180/55ZR17');
		selbox3.options[selbox3.options.length] = new Option('190/50ZR17','190/50ZR17');
		selbox3.options[selbox3.options.length] = new Option('190/55ZR17','190/55ZR17');
		selbox4.options[selbox4.options.length] = new Option('V','V');
		selbox4.options[selbox4.options.length] = new Option('W','W');
	} 
	if (chosen2 == "Power Cup") { 
		selbox3.options[selbox3.options.length] = new Option('180/55ZR17','180/55ZR17');
		selbox3.options[selbox3.options.length] = new Option('190/55ZR17','190/55ZR17');
		selbox3.options[selbox3.options.length] = new Option('200/55ZR17','200/55ZR17');
		selbox4.options[selbox4.options.length] = new Option('W','W');
	} 
	if (chosen2 == "Power Pure") { 
		selbox3.options[selbox3.options.length] = new Option('180/55ZR17','180/55ZR17');
		selbox3.options[selbox3.options.length] = new Option('190/50ZR17','190/50ZR17');
		selbox3.options[selbox3.options.length] = new Option('190/55ZR17','190/55ZR17');
		selbox3.options[selbox3.options.length] = new Option('200/50ZR17','200/50ZR17');
		selbox4.options[selbox4.options.length] = new Option('W','W');
	} 
} 
--> 
</script> 
<div id="hoverbox"></div>
<h1 class="BlueTextBigTB">      Step 2: Tyre Information</h1>
      <form id="form1" name="form1" method="post" action="step3.php">
        <blockquote>
          <table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="200"><span class="HeadingText">QUANTITY:</span></td>
              <td><select name="quantity" class="BlueTextBig" id="quantity">
                <option value="2">2</option>
                <option value="3">3</option>
              </select>
              </td>
            </tr>
          </table>
          <p class="HeadingText">FRONT:          </p>
        </blockquote>
        <table width="500" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CEE1EF">
          <tr>
            <td><table border="0" align="center" cellpadding="5" cellspacing="0">

              <tr>
                <td class="BlueTextBig">Tread Pattern:</td>
                <td width="250"><select name="treadpattern2" class="BlueTextBig" id="treadpattern2" onchange="setOptions(document.form1.treadpattern2.options[document.form1.treadpattern2.selectedIndex].value);">
                    <option selected="selected">please select...</option>
                    <option>Anakee 2</option>
                    <option>Commander 2</option>
                    <option>Pilot Activ</option>
                    <option>Pilot Power 2CT</option>
                    <option>Pilot Road</option>
                    <option>Pilot Road 2</option>
                    <option>Pilot Road 3</option>
                    <option>Power Cup</option>
                    <option>Power Pure</option>
                  </select>                </td>
              </tr>
              <tr>
                <td class="BlueTextBig">Tyre Size:</td>
                <td nowrap="nowrap"><select name="tyresize" class="BlueTextBig" id="tyresize">
                  </select>
                    <img src="images/Help3.jpg" width="28" height="28" border="0" align="absmiddle" /></td>
              </tr>
              <tr>
                <td class="BlueTextBig">Speed Index:</td>
                <td><select name="speedindex" class="BlueTextBig" id="speedindex">
                  </select>                </td>
              </tr>

            </table></td>
          </tr>
        </table>
        <blockquote>
          <p class="HeadingText">REAR: </p>
        </blockquote>
        <table width="500" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CEE1EF">
          <tr>
            <td><table border="0" align="center" cellpadding="5" cellspacing="0">

                <tr>
                  <td class="BlueTextBig">Tread Pattern:</td>
                  <td width="250"><select name="treadpattern4" class="BlueTextBig" id="treadpattern4" onchange="setOptions2(document.form1.treadpattern4.options[document.form1.treadpattern4.selectedIndex].value);">
                      <option selected="selected">please select...</option>
                    <option>Anakee 2</option>
                    <option>Commander 2</option>
                    <option>Pilot Activ</option>
                    <option>Pilot Power 2CT</option>
                    <option>Pilot Road</option>
                    <option>Pilot Road 2</option>
                    <option>Pilot Road 3</option>
                    <option>Power Cup</option>
                    <option>Power Pure</option>
                    </select>                  </td>
                </tr>
                <tr>
                  <td class="BlueTextBig">Tyre Size:</td>
                  <td nowrap="nowrap"><select name="tyresize2" class="BlueTextBig" id="tyresize2">
                    </select>
                      <img src="images/Help3.jpg" width="28" height="28" border="0" align="absmiddle" /></td>
                </tr>
                <tr>
                  <td class="BlueTextBig">Speed Index:</td>
                  <td><select name="speedindex2" class="BlueTextBig" id="speedindex2">
                  </select></td>
                </tr>

            </table></td>
          </tr>
        </table>
        <br />
        <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#00124C">
          <tr>
            <td><table border="0" align="right" cellpadding="5" cellspacing="0">

                <tr>
                  <td><input type="hidden" name="dealer" id="dealer" value="<?php echo $_POST['dealer']; ?>" />
                      <input type="hidden" name="salesman" id="salesman" value="<?php echo $_POST['salesman']; ?>" />
                      <input name="invoice" type="hidden" id="invoice" value="<?php echo $_POST['invoice']; ?>" />
                      <input name="purchasedate" type="hidden" id="purchasedate" value="<?php echo mktime(12,0,0,$_POST[sd_m],$_POST[sd_d],$_POST[sd_y]); ?>" />
                      <input name="warning3" type="text" disabled="disabled" class="RedBoldText" id="warning3" size="23" /></td>
                  <td><input name="button3" type="submit" class="BlueTextBig" id="button3" value="Next &gt;&gt;" onmouseover="validate()" /></td>
                </tr>
            </table>
              <div align="right"></div></td>
          </tr>
        </table>
        <p align="center"><span class="BlueTextBigTB"><img src="images/step2.jpg" width="120" height="22" /></span></p>
      </form>
