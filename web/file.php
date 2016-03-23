<?php

require_once 'utils.php';

global $filepath, $name, $need_body, $self_url;

function bodyless_header($header_string, $response_code=null) {
  global $need_body;
  $need_body = false;
  if ($response_code)
    header($header_string, true, $response_code);
  else
    header($header_string);
}

function write_type() {

  global $filepath;

  $type_spec = get('type', ['default'=>'true']);
  if ($type_spec!='_') {
    if ($type_spec=='true') {
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime_type = finfo_file($finfo, $filepath);
      finfo_close($finfo);
    } else {
      $mime_type = urldecode($type_spec);
    }
    header("Content-Type: " . $mime_type);
  }

}

function write_length() {

  global $filepath;

  $length_spec = get('length', ['default'=>'true']);
  if ($length_spec!='_') {
    if ($length_spec=='true') {
      header("Content-Length: " . filesize($filepath));
    } else {
      header("Content-Length: " . $length_spec);
    }
  }

}

function write_etag() {

  global $name;

  $etag = null;
  $etag_spec = get('etag', ['default'=>sha1($name)]);
  if ($etag_spec!='_') {
    $etag = '"' . $etag_spec . '"';
    header('Etag: ' . $etag);
  }

  if ($etag && $etag==server('HTTP_IF_NONE_MATCH')) {
    bodyless_header('X-Not-Modified-On: ETag');
    bodyless_header('HTTP/1.0 304 Not Modified', 304);
  }

}

function write_last_modified() {

  $formatted_last_modified_time = null;
  $epoch_secs = get('last_modified', ['default'=>1391848200]);
  if ($epoch_secs!='_') {
    $last_modified_time = new DateTime("@$epoch_secs");
    $time_format = 'D, d M Y H:i:s O';
    $formatted_last_modified_time = $last_modified_time->format($time_format);
    header('Last-Modified: ' . $formatted_last_modified_time);
  }

  if ($formatted_last_modified_time && $formatted_last_modified_time==server('HTTP_IF_MODIFIED_SINCE')) {
    bodyless_header('X-Not-Modified-On: Last-Modified');
    bodyless_header('HTTP/1.0 304 Not Modified', 304);
  }

}

function get_filepath() {

  global $name;

  $name = preg_replace("/[^a-zA-Z0-9.]+/", "", get('name', ['default'=>'freakowild.mp3']));
  return './media/' . $name;

}

# Redirect can be a URL or an integer. If it's an integer, it will "count down" 
# by redirecting to the integer minus one, until zero is reached.
# Permanent redirects are handled with the same mechanism, and a check happens at
# the end to output the extra permanent-redirect header
function write_redirect() {

  global $self_url;

  # redirect param
  # - key may be either "redirect" or "permanent_redirect" depending
  #   on the type of redirect we want.
  # - value is either the location URL or a number. If it's a number,
  #   it will "count down" via redirects until the number equals zero
  $redirect = get(
    'redirect',[
      'default' => get(
        'permanent_redirect',[
          'default' => get('relative_redirect')
        ]
      )
    ]
  );
  $redirect = urldecode($redirect);

  # stop counting down if we hit zero
  if ($redirect == '0' || strlen($redirect)==0) {
    return;
  }

  # "count down" the rediret value. this will work for both permanent and regular redirect
  if (intval($redirect) > 0) {
    $redirect = $self_url . preg_replace('/redirect=(\d+)/', 'redirect=' . (intval($redirect)-1), $_SERVER['REQUEST_URI']);

  }

  # Set status code based on the kind of redirect we want
  if (get('permanent_redirect')) {
    header("HTTP/1.1 301 Moved Permanently");
    $status = 301;
  } else {
    $status = 302;
  }

  bodyless_header('Location: ' . urldecode($redirect), $status);
  die();
  return;

}

# prepare
#$url_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$self_url = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
$self_url .= $_SERVER['HTTP_HOST']; #. $url_parts[0];
$pre_delay = limit(0, intval(get('predelay', ['default'=>'0'])), 60);
$post_delay = limit(0, intval(get('postdelay', ['default'=>'0'])), 60);
sleep($pre_delay);

# Open file and write output
$need_body = true;
$filepath = get_filepath();
if (file_exists($filepath))
  $fp = fopen($filepath, 'rb');
else {
  bodyless_header("HTTP/1.0 404 Not Found", 404);
  die();
}

write_redirect();
write_type();
write_length();
write_etag();
write_last_modified();
if ($need_body)
  fpassthru($fp);

# Finish
sleep($post_delay);
fclose($fp);

?>
