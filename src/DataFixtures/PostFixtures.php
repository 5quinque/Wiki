<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class PostFixtures extends Fixture
{
    public function getOrder()
    {
        return 2;
    }
    public function load(ObjectManager $manager)
    {
        $mysql_category = $this->getReference(CategoryFixtures::MYSQL_CATEGORY_REFERENCE);
        $linux_category = $this->getReference(CategoryFixtures::LINUX_CATEGORY_REFERENCE);
        $programming_category = $this->getReference(CategoryFixtures::PROGRAMMING_CATEGORY_REFERENCE);
        $other_category = $this->getReference(CategoryFixtures::OTHER_CATEGORY_REFERENCE);

        $post = new Post();
        $post->setTitle("View all incoming HTTP requests");
        $post->setSlug("view-incoming-http-requests");
        $post->setContent("<p>Viewing incoming <em>HTTP</em> requests can be using for finding a high amount of requests going to a certain domain on your server.</p>\r\n<p>To view all <strong>HTTP GET </strong>requests, run the following command as root:</p>\r\n<p><code>tcpdump -s 0 -A \'tcp[((tcp[12:1] &amp; 0xf0) &gt;&gt; 2):4] = 0x47455420\' </code></p>\r\n<p>For <strong>HTTP POST</strong> requests run the following:</p>\r\n<p><code>tcpdump -s 0 -A \'tcp[((tcp[12:1] &amp; 0xf0) &gt;&gt; 2):4] = 0x504f5354\' </code></p>");
        $post->setCategory($linux_category);
        $post->setCreated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle("Restoring MySQL Database");
        $post->setSlug("restoring-mysql-database");
        $post->setContent("<p>There's a few ways to restore a MySQL database. If you have the SQL dump file, it's relatively easy you can simply import it.</p>\r\n<p>If you have a copy of the data directory (<em>/var/lib/mysql</em>) you can use the following technique.</p>\r\n<p>In this example the data directory I want to get the database from is located at /tmp/mysql160407</p>\r\n<p><code>mysqld_safe --skip-grant-tables --port=3307 --socket=/var/lib/mysql/mysql2.sock --pid-file=/var/run/mysqld/mysqld2.pid --datadir=/tmp/mysql160407 &amp; mysqldump --protocol=TCP --port=3307 --all-databases &gt; /tmp/mysql160407.sql </code></p>\r\n<p>You will now have an SQL dump file located at /tmp/mysql160407.sql</p>");
        $post->setCategory($mysql_category);
        $post->setCreated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle("Delete files before certain date");
        $post->setSlug("delete-files-before-certain-date");
        $post->setContent("<p>If you have a directory with a large amount of file, you may want to delete all files before a certain date.</p>\r\n<p>With the below example, we can delete all files before 2016-01-01 00:00.</p>\r\n<p><code> touch -t 201601010000 /tmp/timestamp</code></p>\r\n<p><code>find . -type f ! -newer /tmp/timestamp -delete </code></p>");
        $post->setCategory($linux_category);
        $post->setCreated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle("Formatting a cron job");
        $post->setSlug("formatting-a-cron-job");
        $post->setContent("<p>Format for cron jobs</p>\r\n<p><code>mi h d m w command </code></p>\r\n<p><strong>Examples</strong>:</p>\r\n<p>Run at ten minutes past the hour, every hour, day etc.</p>\r\n<p><code>10 * * * * ls </code></p>\r\n<p>Run every five minutes, on the 6th hour, every day etc.</p>\r\n<p><code>*/5 6 * * * ls </code></p>\r\n<p>Run on the 14th, 29th, 44th and 59th minute of every hour etc.</p>\r\n<p><code>14,29,44,59 * * * * ls</code></p>");
        $post->setCategory($linux_category);
        $post->setCreated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle("Postfix remove emails from mail queue");
        $post->setSlug("postfix-remove-emails-from-mail-queue");
        $post->setContent("<p>Remove all emails in queue</p>\r\n<p><code>postsuper -d ALL </code></p>\r\n<p>Remove all emails relating to email address</p>\r\n<p><code>postqueue -p | tail -n +2 | awk 'BEGIN { RS = \"\" } /email\\.address@example\\.com/ { print $1 }' | tr -d '*!' | postsuper -d -</code></p>");
        $post->setCategory($linux_category);
        $post->setCreated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle("Silencing a cron job");
        $post->setSlug("silencing-a-cron-job");
        $post->setContent("<p>Append <code>&gt;/dev/null 2&gt;&amp;1</code> to a cron job to silence all output.</p>\r\n<p>The following example sends STDOUT (1) and STDERR (2) to /dev/null, effectively silencing all output.</p>\r\n<p><code>0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp; *&nbsp; *&nbsp; *&nbsp;&nbsp;&nbsp; /bin/bash /opt/somescript.sh &gt;/dev/null 2&gt;&amp;1</code></p>");
        $post->setCategory($linux_category);
        $post->setCreated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle("Vim Search and Replace");
        $post->setSlug("vim-search-and-replace");
        $post->setContent("<p>You can search and replace in vim using the&nbsp;:s (substitute) command.</p>\r\n<dl>\r\n<dd>s will substitute on the current line. For example, the following will only replace the word potatoe on the current line:</dd>\r\n<dd><code>:s/potatoe/tomatoe</code></dd>\r\n</dl>\r\n<dl>\r\n<dd>%s will substitute on all lines in the file. For example, the following will replace the first occurrence of potatoe on every line:</dd>\r\n<dd><code>:%s/potatoe/tomatoe</code></dd>\r\n</dl>\r\n<h4><span id='Flags' class='mw-headline'>Flags</span></h4>\r\n<ul>\r\n<li>g - Global (All occurrences)</li>\r\n<li>c - Ask for confirmation</li>\r\n<li>i - Case insensitive</li>\r\n<li>I - Case sensitive</li>\r\n</ul>\r\n<p><code>:%s/search_keyword/replace_with_this/g </code></p>\r\n<h4><span id='Delimiters' class='mw-headline'>Delimiters</span></h4>\r\n<p>When using the substitute command you can use other delimiters other than \'/\'. This is useful if you\'re replace something like a URL with a lot of slashes in it. E.g:</p>\r\n<p><code>:%s_http://google.com/a/url_https://bing.com/b/url_g </code></p>");
        $post->setCategory($programming_category);
        $post->setCreated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle("Monitor what is accessing/modifying a file");
        $post->setSlug("monitor-what-is-accessingmodifying-a-file");
        $post->setContent("<p>To watch a file for changes, you can do this with auditctl&nbsp;with the following command:</p>\r\n<p><code>auditctl -w /path/to/filename -p wa</code></p>\r\n<p>All changes will then be shown in the audit log (/var/log/audit/audit.log)</p>\r\n<p><code>tail -f /var/log/audit/audit.log</code></p>\r\n<p>Once you have found what you\'re looking for, remove the watch with the following:</p>\r\n<p><code>auditctl -W /path/to/filename -p wa</code></p>");
        $post->setCategory($linux_category);
        $post->setCreated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle("Upgrade MySQL using MySQL Community Repository");
        $post->setSlug("upgrade-mysql-using-mysql-community-repository");
        $post->setContent("<p>Find the correct release RPM for your version of CentOS from the MySQL Download Page (https://dev.mysql.com/downloads/repo/yum/)</p>\r\n<p><code>cat /etc/redhat-release</code></p>\r\n<p><code>&nbsp; CentOS release 6.8 (Final)</code></p>\r\n<p><code>wget&nbsp;https://dev.mysql.com/get/mysql57-community-release-el6-9.noarch.rpm</code></p>\r\n<p><code>yum localinstall mysql57-community-release-el6-9.noarch.rpm</code></p>\r\n<p>&nbsp;</p>\r\n<p>Edit the following file and enable the version of MySQL that you want to upgrade to. Also ensure you disable the ones you don\'t want.<code><br /></code></p>\r\n<p>&nbsp;</p>\r\n<p class='MsoNormal'><code>vim /etc/yum.repos.d/mysql-community.repo</code></p>\r\n<p>&nbsp;</p>\r\n<p><code>yum update mysql-server</code></p>\r\n<p>&nbsp;</p>\r\n<p><code>mysql_upgrade</code></p>\r\n<p>&nbsp;If you\'re using Plesk, you will need to run mysql_upgrade with the following parameters:</p>\r\n<p><code>mysql_upgrade -uadmin -p`cat /etc/psa/.psa.shadow`</code></p>");
        $post->setCategory($linux_category);
        $post->setCreated(new \DateTime());
        $manager->persist($post);


        for ($i = 0; $i < 20; $i++) {
            $post = new Post();
            $post->setTitle("Test Title {$i}");
            $post->setSlug("test{$i}");
            $post->setContent("This is some test{$i} content");
            $post->setCategory($other_category);
            $post->setCreated(new \DateTime());
            $manager->persist($post);
        }

        $manager->flush();
    }
}
