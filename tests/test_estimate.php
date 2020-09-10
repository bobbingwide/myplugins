<?php



$days_diff = days_diff( '2020/09/08', '2020/10/09');

$estimated_value = estimate( '2020/09/10', null, '2020/09/08', 418150, '2020/09/09', 418282 );
//$this->assertEquals( $estimated_value, 418414);

$estimated_value = estimate( '2020/09/04', null, '2020/08/06', 0, '2020/08/19', 65);
$estimated_value = estimate( '2020/09/04', null, '2020/08/19', 65, '2020/09/09', 107);
$estimated_value = estimate( '2020/09/05', null, '2020/08/19', 65, '2020/09/09', 107);
$estimated_value = estimate( '2020/09/06', null, '2020/08/19', 65, '2020/09/09', 107);

