<?php
/* @var $this SiteController */
/*
$app = Yii::app();
if ($app->user->hasState('_lang'))
	$app->language = $app->user->getState('_lang');
else if (isset($app->request->cookies['_lang'])) {
	$app->language = Yii::app()->request->cookies['_lang']->value;
}
 */
Yii::app()->user->returnUrl = $this->createUrl('/site/page&view=policy');
require('locale.php');

$this->pageTitle=Yii::app()->name . ' - '. Yii::t('pages', 'policy.header');
$this->breadcrumbs=array(
	Yii::t('pages', 'policy.header'),
);
?>
<div class="content">
<h1><?php echo Yii::t('pages', 'policy.header'); ?></h1>

<p>
The Webmaster of the
<a href="http://www.osonpay.tj/">osonpay</a>
Web site is committed to
protecting the privacy of contributors and users of this Web site.
</p>
<p>
The Webmaster of this Web site intends to give you as much control as
possible over your personal information, including registration data if and
when applicable. As part of the normal operation of the
<a href="http://www.osonpay.tj/">osonpay</a>
 Web site,
we may, at our discretion, collect information from you. This Privacy
Statement describes the information we collect about you and how that
information may be used.
</p>
<h2>Information Gathered through the
<a href="http://www.osonpay.tj/">osonpay</a>
 Web site</h2>
<p>
The Webmaster of this Web site will track the domains from which people
visit the Web site in order to gain aggregate data that may be analyzed
for trends and statistics. Subject to the provisions of this Privacy
Statement, the Webmaster may use accumulated aggregate data for several
purposes including, but not limited to, marketing analysis, evaluation of
the Web site’s services, and business planning.
</p>
<h2>E-mail sent by visitors of this Web site</h2>
<p>
This Web site allows you to send E-mail messages to certain people
and/or mailing lists, who are mentioned and/or advertised in this Web site.
In such cases, the sender’s valid E-mail address will be included with such
messages along with a note saying that this Web site was used to send the
E-mail message in question. In order to prevent abuse, users may not opt-out
of such a display, but may choose to refrain from using this Web site to
transmit an E-mail message.
</p>
<p>
The Webmaster may, at his discretion, get a copy of those E-mail messages,
for the purposes of ensuring the proper operation of this Web site, provision
of additional and improved services to visitors of this Web site, and/or
investigation of spam complaints. This includes E-mail messages sent to
Sign Language interpreters.
</p>
<h2>Cookies</h2>
<p>
This Web site employs “cookies” to provide users with tailored information.
A “cookie” is an element of data that a Web site, when visited by a user,
sends to that user’s browser which, in turn, may store that element on the
user’s hard drive or memory. This Web site uses cookies to better serve
users of this Web site; any cookies sent by this Web site will be marked so
that they will be accessible only by this Web site and affiliate Web sites
subject to this Privacy Statement. However, at his or her option and at his
or her sole expense and responsibility, any user may block or delete our
cookies from his or her hard drive. However, by disabling cookies, certain
site features and functionality may no longer work properly, or at all.
</p>
<h2>Other Notification</h2>
<p>
The Webmaster of this Web site may use user-provided E-mail addresses to
contact users on an individual basis. At no time, unless such disclosure
is required by law, a governmental agency, or specifically authorized by the
user, will the Webmaster disclose individual user personal information to
unrelated third parties that is not publicly available.
</p>
<h2>Links with other sites</h2>
<p>
This Web site contains links to other Web sites, whether owned or controlled
by the Webmaster, or by unrelated third parties. Please note that the privacy
policies of these sites may differ from those of this Web site. The Webmaster
of this Web site is not responsible for the privacy policies and practices of
any linked Web site. We encourage you to read the privacy statement of any
Web site you may visit.
</p>
<h2>Security</h2>
<p>
To secure site integrity, this Web site’s Webmaster may employ, at his
discretion, measures, including but not limited to security audits, use of
encryption tools and software, and other reasonable security measures and
procedures.
</p>
<p>
Internal access to users’ private and nonpublic personal information is
restricted to site administrators and individuals on a need-to-know basis.
</p>
<h2>Enforcement</h2>
<p>
In the event that the Webmaster of this Web site becomes aware that site
security is compromised or nonpublic user information has been disclosed
to unrelated third parties as a result of external activity, including but
not limited to external security attacks, the Webmaster shall take reasonable
measures which it deems appropriate, including but not limited to internal
investigation and reporting, and notification to and cooperation with law
enforcement authorities, notwithstanding other provisions of this Privacy
Statement.
</p>
<p>
If the Webmaster becomes aware that a user’s personal information provided
via this Web site has been disclosed in a manner not in accordance with this
Privacy Statement, the Webmaster shall make reasonable efforts to notify the
affected user, as soon as reasonably possible and as permitted by law, of
what information has been disclosed, to the extent that the Webmaster knows
this information.
</p>
<h2>No Guarantees For Factors Beyond this Web site’s Webmaster control</h2>
<p>
While this Privacy Statement expresses the Webmaster’s standards for
maintenance of private data, he is not in a position to guarantee that the
standards will always be met. There may be factors beyond the Webmaster’s
control (e.g., “script kiddies”, “crackers and other malcontents”) that may
result in disclosure of data. As a consequence, the Webmaster disclaims any
warranties or representations relating to maintenance or nondisclosure of
private information.
</p>
<h2>Third Party Advertising</h2>
<p>
This Web site uses various third-party advertising companies to display ads
when you visit it. Those companies may use anonymous information (not
including your name, address, E-mail address or telephone number) about your
visits to this Web site (and Web sites operated by others) in order to
provide advertisements on this Web site about goods and services that may
be of interest to you.
</p>
<h3>Third Party Cookies</h3>
<p>
In the course of serving advertisements to users of this Web site, our
third-party advertisers may place or recognize a unique “cookie” on your
browser.
</p>
<p>
Please note that the privacy policies of those third-party advertisers may
differ from those of this Web site. The Webmaster of this Web site is not
responsible for the privacy policies and practices of those advertisers.
We encourage you to read the privacy statement of any Web site you may visit.
</p>
<p>
However, at his or her option and at his or her sole expense and
responsibility, any user may block or delete third-party advertisers’
cookies from his or her hard drive. Disabling or removing such cookies
is not expected to impair features of functionality of this Web site, although
it may impair features or functionality of third-party advertisers’ Web
sites.
</p>
<p><b>Last modified:</b> 12 May 2009</p>
</div>
