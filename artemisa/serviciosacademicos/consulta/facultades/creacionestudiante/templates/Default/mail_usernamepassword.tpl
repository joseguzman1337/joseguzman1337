To: {$user.email}
Subject: Login information for survey
<!-- HEADER SEPERATOR - DO NOT REMOVE -->
Hello {$user.name}. This email will provide you with the username
and password required to access a survey on our site.

Survey: {$survey.name}
  Username: {$user.username}
  Password: {$user.password}

{section name="take" loop=1 show=$user.take_priv}
To take the survey, visit the following URL:
{$survey.take_url}
{/section}

{section name="results" loop=1 show=$user.results_priv}
To view the results of this survey:
{$survey.results_url}
{/section}

{section name="edit" loop=1 show=$user.edit_priv}
To edit this survey:
{$survey.edit_url}
{/section}

Main Page:
{$survey.main_url}