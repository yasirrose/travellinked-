<div class="engine-dropdown" id="horiz-box">

    <?php

	$rooms = intval(session()->get("num_rooms"));

	$adultsTotal = session()->get("adults");

	$arrAdults = session()->get("adultsArr");

	$arrAges = session()->get("childAgesArr");

	$arrChild = session()->get("childsArr");

	for($i = 1; $i<=5; $i++){

	$style = ""; 

	$styleAges = ""; 

	$j = $i-1;

	$children = "";

	$curAges = array();

	if($i > $rooms){

		$style = 'style="display:none"';

	}

	$childCount = 0;

	$childAgeStyle = '';

	if(empty($style)){

		$children = $arrChild[$j].' Children';

		$childCount = intval($arrChild[$j]);

		if(empty($childCount) || $childCount == 0)

		{

			$childAgeStyle = 'style="display:none"';

			$children = 'No Children';

			for($a = 0; $a < 8; $a++)

			{

				$index = count($curAges);

				$curAges[$index]['age'] = '';

				$curAges[$index]['style'] = 'disabled="disabled"';

			}

		}

		else

		{

			$ageIndex = 'room'.$i;

			$ageComponent = $arrAges[$ageIndex];

			for($a = 0; $a < 8; $a++)

			{

				$childAgeStyle = '';

				$index = count($curAges);

				if($a < count($ageComponent))

				{

					$curAges[$index]['age'] = $ageComponent[$a];

					$curAges[$index]['style'] = '';

				}

				else

				{

					$curAges[$index]['age'] = '';

					$curAges[$index]['style'] = 'disabled="disabled"';

				}	

			}

		}

	}

	else

	{

		$children = 'No Children';

		for($a = 0; $a < 8; $a++)

		{

			$childAgeStyle = 'style="display:none"';

			$index = count($curAges);

			$curAges[$index]['age'] = '';

			$curAges[$index]['style'] = 'disabled="disabled"';

		}

	}

	?>

    <div class="engine-dropdown-row" <?php echo $style ?>>

        <div class="rows-3">

            <div class="engine-dropdown-rooms">

                <?php if($i == 1){ ?>

                <label>Rooms</label>

                <div class="icon-control">

                    <select class="control-field" id="rooms_change" name="total_rooms">

                        <option value="<?php echo $rooms ?>" selected="selected" hidden="hidden"><?php echo $rooms ?> Room</option>

                        <option value="1">1 Room</option>

                        <option value="2">2 Rooms</option>

                        <option value="3">3 Rooms</option>

                        <option value="4">4 Rooms</option>

                        <option value="5">5 Rooms</option>

                    </select>

                    <span class="ion ion-arrow-down-b"></span>

                </div>

                <?php }else{ ?>

                <label class="label-rooms">Room <?php echo $i ?></label>

                <?php } ?>

            </div>

            <div class="engine-dropdown-adults">

                <label>Adults</label>

                <div class="icon-control">

                    <select class="control-field adults-sticky" id="adultsticky-<?php echo $i ?>" name="adults_<?php echo $i ?>">

                         <option value="1">1 Adult</option>

                         <?php

                         if(empty($style)){

						 if($arrAdults[$j] > 1){

						 ?>

                         <option value="<?php echo $arrAdults[$j] ?>" selected="selected" hidden="hidden"><?php echo $arrAdults[$j] ?> Adults</option>

						 <?php }else{ ?>

                         <option value="<?php echo $arrAdults[$j] ?>" selected="selected" hidden="hidden"><?php echo $arrAdults[$j] ?> Adult</option>

                         <?php } ?>

                         <option value="2">2 Adults</option>

						 <?php }else{ ?>

                         <option value="2" selected="selected">2 Adults</option>

                         <?php } ?>

                         <option value="3">3 Adults</option>

                         <option value="4">4 Adults</option>

                         <option value="5">5 Adults</option>

                    </select> 

                    <span class="ion ion-arrow-down-b"></span>

                </div>	

            </div>

            <div class="engine-dropdown-children">

                <label>Children</label>

                <div class="icon-control">

                    <select class="control-field total_children horiz-child" name="children_<?php echo $i ?>" id="total_child_sticky<?php echo $i ?>">

                        <option value="<?php echo $childCount ?>" selected="selected" hidden="hidden"><?php echo $children ?></option>

						<option value="">No Children</option>

                        <option value="1">1 Child</option>

                        <option value="2">2 Children</option>

                        <option value="3">3 Children</option>

                        <option value="4">4 Children</option>

                        <option value="5">5 Children</option>

                        <option value="6">6 Children</option>

                        <option value="7">7 Children</option>

                        <option value="8">8 Children</option>

                    </select>

                    <span class="ion ion-arrow-down-b"></span>

                </div>

            </div>

            <div class="clear"></div>

        </div>   

        <div class="chldr-age-row total_child_sticky<?php echo $i ?>_ages" <?php echo $childAgeStyle ?>>

            <label>Children’s Ages (0 - 17)</label>

            <div class="age-select-boxes">

                <div class="icon-control">

                    <select class="control-field" name="children_<?php echo $i ?>_age_1" <?php echo $curAges[0]['style'] ?> id="childsticky_<?php echo $i ?>_ages_1">

                        <option value="<?php echo $curAges[0]['age'] ?>" selected="selected" hidden="hidden"><?php echo $curAges[0]['age'] ?></option>

                        <option value="1">1</option>

                        <option value="2">2</option>

                        <option value="3">3</option>

                        <option value="4">4</option>

                        <option value="5">5</option>

                        <option value="6">6</option>

                        <option value="7">7</option>

                        <option value="8">8</option>

                        <option value="9">9</option>

                        <option value="10">10</option>

                        <option value="11">11</option>

                        <option value="12">12</option>

                        <option value="13">13</option>

                        <option value="14">14</option>

                        <option value="15">15</option>

                        <option value="16">16</option>

                        <option value="17">17</option>

                    </select>

                    <span class="ion ion-arrow-down-b"></span>

                </div>

                <div class="icon-control">

                    <select class="control-field age-2" name="children_<?php echo $i ?>_age_2" <?php echo $curAges[1]['style'] ?> id="childsticky_<?php echo $i ?>_ages_2">

                        <option value="<?php echo $curAges[1]['age'] ?>" selected="selected" hidden="hidden"><?php echo $curAges[1]['age'] ?></option>

                        <option value="1">1</option>

                        <option value="2">2</option>

                        <option value="3">3</option>

                        <option value="4">4</option>

                        <option value="5">5</option>

                        <option value="6">6</option>

                        <option value="7">7</option>

                        <option value="8">8</option>

                        <option value="9">9</option>

                        <option value="10">10</option>

                        <option value="11">11</option>

                        <option value="12">12</option>

                        <option value="13">13</option>

                        <option value="14">14</option>

                        <option value="15">15</option>

                        <option value="16">16</option>

                        <option value="17">17</option>

                    </select>

                    <span class="ion ion-arrow-down-b"></span>

                </div>

                <div class="icon-control">

                    <select class="control-field age-3" name="children_<?php echo $i ?>_age_3" <?php echo $curAges[2]['style'] ?> id="childsticky_<?php echo $i ?>_ages_3">

                        <option value="<?php echo $curAges[2]['age'] ?>" selected="selected" hidden="hidden"><?php echo $curAges[2]['age'] ?></option>

                        <option value="1">1</option>

                        <option value="2">2</option>

                        <option value="3">3</option>

                        <option value="4">4</option>

                        <option value="5">5</option>

                        <option value="6">6</option>

                        <option value="7">7</option>

                        <option value="8">8</option>

                        <option value="9">9</option>

                        <option value="10">10</option>

                        <option value="11">11</option>

                        <option value="12">12</option>

                        <option value="13">13</option>

                        <option value="14">14</option>

                        <option value="15">15</option>

                        <option value="16">16</option>

                        <option value="17">17</option>

                    </select>

                    <span class="ion ion-arrow-down-b"></span>

                </div>

                <div class="icon-control">

                    <select class="control-field age-4" name="children_<?php echo $i ?>_age_4" <?php echo $curAges[3]['style'] ?> id="childsticky_<?php echo $i ?>_ages_4">

                        <option value="<?php echo $curAges[3]['age'] ?>" selected="selected" hidden="hidden"><?php echo $curAges[3]['age'] ?></option>

                        <option value="1">1</option>

                        <option value="2">2</option>

                        <option value="3">3</option>

                        <option value="4">4</option>

                        <option value="5">5</option>

                        <option value="6">6</option>

                        <option value="7">7</option>

                        <option value="8">8</option>

                        <option value="9">9</option>

                        <option value="10">10</option>

                        <option value="11">11</option>

                        <option value="12">12</option>

                        <option value="13">13</option>

                        <option value="14">14</option>

                        <option value="15">15</option>

                        <option value="16">16</option>

                        <option value="17">17</option>

                    </select>

                    <span class="ion ion-arrow-down-b"></span>

                </div>

                <div class="icon-control">

                    <select class="control-field age-5" name="children_<?php echo $i ?>_age_5" <?php echo $curAges[4]['style'] ?> id="childsticky_<?php echo $i ?>_ages_5">

                        <option value="<?php echo $curAges[4]['age'] ?>" selected="selected" hidden="hidden"><?php echo $curAges[4]['age'] ?></option>

                        <option value=""></option>

                        <option value="1">1</option>

                        <option value="2">2</option>

                        <option value="3">3</option>

                        <option value="4">4</option>

                        <option value="5">5</option>

                        <option value="6">6</option>

                        <option value="7">7</option>

                        <option value="8">8</option>

                        <option value="9">9</option>

                        <option value="10">10</option>

                        <option value="11">11</option>

                        <option value="12">12</option>

                        <option value="13">13</option>

                        <option value="14">14</option>

                        <option value="15">15</option>

                        <option value="16">16</option>

                        <option value="17">17</option>

                    </select>

                    <span class="ion ion-arrow-down-b"></span>

                </div>

                <div class="icon-control">

                    <select class="control-field age-6" name="children_<?php echo $i ?>_age_6" <?php echo $curAges[5]['style'] ?> id="childsticky_<?php echo $i ?>_ages_6">

                        <option value="<?php echo $curAges[5]['age'] ?>" selected="selected" hidden="hidden"><?php echo $curAges[5]['age'] ?></option>

                        <option value="1">1</option>

                        <option value="2">2</option>

                        <option value="3">3</option>

                        <option value="4">4</option>

                        <option value="5">5</option>

                        <option value="6">6</option>

                        <option value="7">7</option>

                        <option value="8">8</option>

                        <option value="9">9</option>

                        <option value="10">10</option>

                        <option value="11">11</option>

                        <option value="12">12</option>

                        <option value="13">13</option>

                        <option value="14">14</option>

                        <option value="15">15</option>

                        <option value="16">16</option>

                        <option value="17">17</option>

                    </select>

                    <span class="ion ion-arrow-down-b"></span>

                </div>

                <div class="icon-control">

                    <select class="control-field age-7" name="children_<?php echo $i ?>_age_7" <?php echo $curAges[6]['style'] ?> id="childsticky_<?php echo $i ?>_ages_7">

                       	<option value="<?php echo $curAges[6]['age'] ?>" selected="selected" hidden="hidden"><?php echo $curAges[6]['age'] ?></option>

                        <option value="1">1</option>

                        <option value="2">2</option>

                        <option value="3">3</option>

                        <option value="4">4</option>

                        <option value="5">5</option>

                        <option value="6">6</option>

                        <option value="7">7</option>

                        <option value="8">8</option>

                        <option value="9">9</option>

                        <option value="10">10</option>

                        <option value="11">11</option>

                        <option value="12">12</option>

                        <option value="13">13</option>

                        <option value="14">14</option>

                        <option value="15">15</option>

                        <option value="16">16</option>

                        <option value="17">17</option>

                    </select>

                    <span class="ion ion-arrow-down-b"></span>

                </div>

                <div class="icon-control">

                    <select class="control-field age-3" name="children_<?php echo $i ?>_age_8" <?php echo $curAges[7]['style'] ?> id="childsticky_<?php echo $i ?>_ages_8">

                        <option value="<?php echo $curAges[7]['age'] ?>" selected="selected" hidden="hidden"><?php echo $curAges[7]['age'] ?></option>

                        <option value="1">1</option>

                        <option value="2">2</option>

                        <option value="3">3</option>

                        <option value="4">4</option>

                        <option value="5">5</option>

                        <option value="6">6</option>

                        <option value="7">7</option>

                        <option value="8">8</option>

                        <option value="9">9</option>

                        <option value="10">10</option>

                        <option value="11">11</option>

                        <option value="12">12</option>

                        <option value="13">13</option>

                        <option value="14">14</option>

                        <option value="15">15</option>

                        <option value="16">16</option>

                        <option value="17">17</option>

                    </select>

                    <span class="ion ion-arrow-down-b"></span>

                </div>

            </div>

            <div class="clear"></div>

        </div>     

    </div>

    <?php } ?>

    <div class="engine-dropdown-btns">

        <button class="btn-addrow" id="addStickyRoom"><i class="icon ion-plus-round"></i> Add Room</button>

        <button class="btn-cnfrm" id="confirmStickyRoom">Confirm</button>

    </div>

</div>