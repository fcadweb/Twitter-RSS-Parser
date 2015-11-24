<?php
if (isset($q)){
	$td = $twitter_data['statuses'];
} else {
	$td = $twitter_data;
}
$arrLen = count($td);
for ($i=0; $i<$arrLen; $i++) {
	print(PHP_EOL. '	<entry>'. PHP_EOL);
		print('		<id>tag:twitter.com,' . date("Y-m-d", strtotime($td[$i]['created_at'])) . ':/' . $td[$i]['user']['screen_name'] . '/statuses/' . $td[$i]['id_str'] . '</id>'. PHP_EOL);
		print('		<link href="https://twitter.com/'.$td[$i]['user']['screen_name'].'/statuses/'. $td[$i]['id_str'] .'" rel="alternate" type="text/html"/>'. PHP_EOL);
		print('		<title>'.$td[$i]['user']['screen_name'].': ' . date('c', strtotime($td[$i]['created_at'])) .'</title>'. PHP_EOL);
		print('		<summary type="html"><![CDATA['.$td[$i]['user']['screen_name'].': '.$td[$i]['text'].']]></summary>'. PHP_EOL);

		$mediaLength = count($td[$i]['entities']['media']);
		if ($mediaLength > 0){
			for ($m=0; $m<$mediaLength; $m++){
				$tweetmedia = '<div class="media"><img src="'. $td[$i]['entities']['media'][$m]['media_url'] . '" /></div>';
				$feedContent = '		<content type="html"><![CDATA[' . $tweetmedia . '<p>'.nl2br($td[$i]['text']).'</p>]]></content>' . PHP_EOL;
				$textutf8 = utf8_encode($feedContent);
				print(    $textutf8 . PHP_EOL);
			}
		} else {
			
			$feedContent = '		<content type="html"><![CDATA[<p>'.nl2br($td[$i]['text']).'</p>]]></content>' . PHP_EOL;
			$text = processString($feedContent);
			$textutf8 = utf8_encode($text);
			print($textutf8 . PHP_EOL);
			
		}

		print('		<updated>'.date('c', strtotime($td[$i]['created_at'])).'</updated>'. PHP_EOL);
		print('		<author><name>'.$td[$i]['user']['screen_name'].'</name></author>'. PHP_EOL);

		$hashLen = count($td[$i]['entities']['hashtags']);
		if ($hashLen > 0){
			for ($j=0; $j<$hashLen; $j++){
				print('		<category term="#'.$td[$i]['entities']['hashtags'][$j]['text'].'"/>'. PHP_EOL);
			}
		}

	print('	</entry>'. PHP_EOL);
}

print('</feed>'. PHP_EOL);
print('<!-- vim:ft=xml -->');
?>