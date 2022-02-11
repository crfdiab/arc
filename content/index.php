<?php
require 'vendor/autoload.php';
use League\HTMLToMarkdown\HtmlConverter;
$converter = new HtmlConverter(array('remove_nodes' => 'span div'));
for ($x = 1; $x <= 100; $x++) {
$send = file_get_contents("https://www.sidmartinbio.org/wp-json/wp/v2/posts/?order=asc&per_page=1&page=$x");
$json = json_decode($send);
$title = $json[0]->title->rendered;
$date = $json[0]->date;
$slug = $json[0]->slug;
$content = $json[0]->content->rendered;
$excerpt = $json[0]->excerpt->rendered;
$content_markdown = $converter->convert($content);
$template = "+++\ntitle = \"$title\"\ndate = $date\ntags = [\"Questions\"]\nslug = \"$slug\"\ndescription = \"$title\"\n+++\n$content_markdown";
$post = fopen($slug. ".md", "w");
fwrite($post, $template);
fclose($post);
echo "Done Writing Post";
break;
}
?>