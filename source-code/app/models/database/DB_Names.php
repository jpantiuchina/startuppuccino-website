<?php
 
/**
 * Database table name variables
 */

define("DB_TABLE_PREFIX", "startuppuccino__");

define("_T_ACCOUNT", DB_TABLE_PREFIX."account"); //+
define("_T_IDEA", DB_TABLE_PREFIX."project"); //+
define("_T_IDEA_ACCOUNT", DB_TABLE_PREFIX."project_participant");
define("_T_IDEA_COMMENT", DB_TABLE_PREFIX."project_comment");
define("_T_IDEA_LIKE", DB_TABLE_PREFIX."project_like");
define("_T_LIKE", DB_TABLE_PREFIX."like");
define("_T_COMMENT", DB_TABLE_PREFIX."comment");
//define("_T_TEAM", "teams");
//define("_T_TEAM_ACCOUNT", "teamaccount");
define("_T_PROJECT", DB_TABLE_PREFIX."project");
define("_T_PROJECT_ACCOUNT", DB_TABLE_PREFIX."project_participant");
define("_T_MILESTONE", DB_TABLE_PREFIX."milestone");
define("_T_PROJECT_MILESTONE", DB_TABLE_PREFIX."project_milestones");

define("_T_SESSION", DB_TABLE_PREFIX."session");
define("_T_SESSION_COMMENT", DB_TABLE_PREFIX."session_comment");
define("_T_MENTOR_AVAILABILITY", DB_TABLE_PREFIX."mentor_availability");
define("_T_ACCOUNT_LOGGED", DB_TABLE_PREFIX."account_logged");

define("_T_RESIDENCE_MENTORS", DB_TABLE_PREFIX."mentor_residence");



define("_T_PROJECT_MENTOR", DB_TABLE_PREFIX."project_mentor");
define("_T_MENTOR_PROJECT", DB_TABLE_PREFIX."mentor_project");

?>