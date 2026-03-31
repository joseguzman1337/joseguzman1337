To: {$user.email}
Subject: Invitation to Participate in Survey
<!-- HEADER SEPERATOR - DO NOT REMOVE -->
Hello {$user.name}. You have been selected to participate in
a survey at the following site. You will need the invitation
code listed in order to access the survey.

Survey: {$survey.name}
Invitation Code: {$user.code}

The following URL already contains your Invitation Code, so
clicking on it or typing it into your browser will take
you directly to the survey.
{$user.take_url}

{section name="results" loop=1 show=$user.results_priv}
You can view the results of this survey at the following URL.
{$survey.results_url}
{/section}

Or, you can alternatively find the survey from our Main
Page and provide your Invitation Code when prompted. The
following URL will take you to our Main Page.
{$survey.main_url}