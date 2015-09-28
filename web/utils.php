<?
function toBase($num) { return base_convert($num, 10, 36); }
function to10( $num) { return base_convert($num, 36, 10); }

function server($key, $default=null) {
  return isset($_SERVER[$key]) ? $_SERVER[$key] : $default;
}

#function get($param_key, $default=null) {
  #return isset($_GET[$param_key]) ? $_GET[$param_key] : $default;
#}

function limit($min, $val, $max) {
  return max($min, min($val, $max));
}

function get($param_key, $options=array()) {
  $options = array_merge([
    'default' => '',
    'left_padding' => '',
    'right_padding' => '',
    'right_padding_if_present' => '',
  ], $options);
  $val = isset($_GET[$param_key]) ? $_GET[$param_key] : $options['default'];
  $val = $options['left_padding'] . $val . $options['right_padding'];
  $val = $val . (strlen($val) > 0 ? $options['right_padding_if_present'] : '');
  return $val;
}

function get_boolean($param_key, $default=true) {
  $str = get($param_key, [ 'default' => ($default ? 'true' : 'false') ]);
  return filter_var($str, FILTER_VALIDATE_BOOLEAN);
}

?>
