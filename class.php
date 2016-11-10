<?php

class Checker
{

  CONST DEBUG = false;

  protected function checkStatus($url)
  {
    $status = get_headers($url)['0'];
    if (self::DEBUG == true) {
      return $status;
    } else {
      return (strpos($status, '200 OK')) ? 'unavailable' : 'available';
    }
  }

  protected function Twitter($username)
  {
    $request = json_decode(file_get_contents("https://twitter.com/users/username_available?username=$username"), true);
    return $request['valid'];
  }

  protected function Instagram($username)
  {
    return self::checkStatus("https://www.instagram.com/" . $username . "/");
  }

  protected function YouTube($username)
  {
    return self::checkStatus("https://www.youtube.com/" . $username . "/");
  }

  protected function Reddit($username)
  {
    return self::checkStatus("https://www.reddit.com/user/" . $username . "/");
  }

  protected function Facebook($username)
  {
    return self::checkStatus("https://www.facebook.com/" . $username . "/");
  }

  /**
  * Checks username on various sites
  *
  * @param $username string
  * @return array
  */
  public function checkUser($username)
  {
    return array(
      'twitter' => (self::Twitter($username)) ? 'available' : 'unavailable',
      'instagram' => self::Instagram($username),
      'facebook' => self::Facebook($username),
      'youtube' => self::YouTube($username),
      //'reddit' => self::Reddit($username) //Reddit has long load time :/
    );
  }

  public function checkUserPrettyPrint($username)
  {
    echo "<pre>";
    print_r(self::checkUser($username));
    echo "</pre>";
  }

}

//Example
// I still do not recommend using PHP, as you can see the load time is significant enough from only couple sites
$c = new Checker();
//print_r($c->checkUser('rumblefrog'));
$c->checkUserPrettyPrint('rumblefrog');
