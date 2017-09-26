<img src="<?php echo  $data['image']; ?>" style="margin-left: 300px">
<br>
<br>
<h3>{{$data['hotel_name']}}</h3>
<br>
<br>
<h3>{{$data['hotel_city']}}</h3>
<h3>{{$data['hotel_state']}}</h3>
<h2>$ {{$data['total_amount']}}</h2>
<br>
<h3>Things To Keep In Mind</h3>

<ul>
    <li>Mandatory Resort Fee is $<?php echo $data['hote_fee']; ?> Per Day Per Room for this Booking</li>
    <li>This Booking is a <span>Non Refundable</span></l>
</ul>
<br><br>
<h2>Fee's</h2>

<h6>Mandatory Resort Fee</h6>
<p>Guests who book the Exclusive room categories will be responsible to pay the Resort Fee of $200 per night.</p>
<br>
<h3>Cancellation Policy</h3>
<p><?php
$cancel = str_replace("<ul>","",$data['policy']);
     $cancel = str_replace("</ul>","",$data['policy']);
  echo $cancel; ?></p>

