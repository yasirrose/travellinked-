<div class="engine-dropdown" id="horiz-box">

    <?php 

	for($i = 1; $i<=5; $i++){

	$style = "";

	if($i > 1)

	{

		$style = 'style="display:none"';

	}

	$curAges = array();

	$children = '0 Children';

	$childAgeStyle = 'style="display:none"';

	for($a = 0; $a < 8; $a++)

	{

		$childAgeStyle = 'style="display:none"';

		$index = count($curAges);

		$curAges[$index]['age'] = 0;

		$curAges[$index]['style'] = 'disabled="disabled"';

	}

	?>

    <div class="engine-dropdown-row" <?php echo $style ?>>

        <div class="rows-3">

            <div class="engine-dropdown-rooms">

                <?php if($i == 1){ ?>

                <label>Rooms</label>

                <div class="icon-control">

                    <select class="control-field" id="rooms_change" name="total_rooms">

                        <option value="1" selected="selected">1 Room</option>

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

                         <option value="2" selected="selected">2 Adults</option>

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

                       	<option value="" selected="selected"></option>

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

                        <option value="" selected="selected"></option>

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

                        <option value="" selected="selected"></option>

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

                        <option value="" selected="selected"></option>

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

                        <option value="" selected="selected"></option>

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

                        <option value="" selected="selected"></option>

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

                       	<option value="" selected="selected"></option>

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

                        <option value="" selected="selected"></option>

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