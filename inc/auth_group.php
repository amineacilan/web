<?php
if ((isset($groupId)) && ($session_type != 'admin') && ($pageName == 'updateGroup' || $pageName == 'updateGroupSettings' || $pageName == 'userGroupSettings'))
{
  $sql = "SELECT id FROM user_group WHERE user_id = $session_user_id AND group_id = $groupId";
  $isInvalidId = ($groupId == '0' || $groupId === '');

  if ( ($isInvalidId && ($pageName != 'updateGroup')) || (!$isInvalidId && ($result = mysql_query($sql, $connection)) && (mysql_num_rows($result) == 0)) )
  {
    echo '<!DOCTYPE html><html><head><title>' . $config_title . '</title><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>';
    die('<br>Bu sayfayı görme yetkiniz yok.');
  }
}