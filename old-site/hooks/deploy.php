<?php
$GITHUB_REPO = "CSClubatIUPUI/react-site";
$OUTPUT_DIR = __DIR__ . "/..";
$TEMP_ZIP_FILENAME = "/tmp/csclub-react-site.zip";

header("Content-Type: application/json");

$ch = curl_init("https://circleci.com/api/v1.1/project/gh/$GITHUB_REPO/latest/artifacts");
curl_setopt_array($ch, [
  CURLOPT_RETURNTRANSFER => true
]);
$artifacts = json_decode(curl_exec($ch), true);
if (count($artifacts) === 0) {
  http_response_code(404);
  die(json_encode(["error" => "No artifacts found for latest build"]));
}

shell_exec("wget -O $TEMP_ZIP_FILENAME \"{$artifacts[0]["url"]}\"");
shell_exec("unzip $TEMP_ZIP_FILENAME -d $OUTPUT_DIR");

shell_exec("cp -r $OUTPUT_DIR/build/* $OUTPUT_DIR/");
shell_exec("cp -r $OUTPUT_DIR/build/.* $OUTPUT_DIR/");
shell_exec("chown -R g+w $OUTPUT_DIR");
shell_exec("chgrp -R csclub $OUTPUT_DIR");

shell_exec("rm -rf $OUTPUT_DIR/build");

json_encode([
  "success" => true,
  "message" => "Deployed new version of React site successfully"
]);
?>
