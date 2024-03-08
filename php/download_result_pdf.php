<?php
include_once("../database/conn.php");
require_once("../vendor/autoload.php");

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set("defaultFont", "Arial, Helvetica, sans-serif");
$options->set("isPhpEnabled", true);

$dompdf = new Dompdf($options);

$id_result = (int)$_GET['id_result'];
$filename = date("YmdHis") . "_result.pdf";
$html = "";

//Get the result's information
$sqlGetResult = "SELECT * FROM results WHERE id_result = $id_result";
$queryGetResult = mysqli_query($conn, $sqlGetResult) or die("Error: get result");
$rowGetResult = mysqli_fetch_assoc($queryGetResult);

$email_user_result = $rowGetResult['email_user_result'];
$content_result = json_decode($rowGetResult['content_result'], true);
$created_at = date("d/m/Y H:i", strtotime($rowGetResult['created_at']));

$title_form = $content_result['title_form'];
$sections = $content_result['sections'];

//Form
$html .= "<div style='padding: 10px; border: 2px solid rgb(229 231 235); border-radius: 6px; margin-bottom: 10px;'>";
$html .= " <h1>$title_form</h1>";
$html .= " <p>$created_at</p>";
$html .= " <p>$email_user_result</p>";
$html .= "</div>";

//Sections
foreach ($sections as $section) {

  $title_section = $section['title_section'];
  $description_section = $section['description_section'];
  $questions = $section['questions'];

  $html .= "<div style='padding: 10px; border: 2px solid rgb(229 231 235); border-radius: 6px; margin-bottom: 10px;'>";
  $html .= " <h2>$title_section</h2>";
  $html .= " <p>$description_section</p>";
  $html .= "</div>";

  //Questions
  foreach ($questions as $question) {

    $name_question = $question['name_question'];
    $type_question = $question['type_question'];
    $required_question = (int)$question['required_question'];
    $final_answer = $question['final_answer'];

    $span_required_question = "";

    if ($required_question == 1) {
      $span_required_question = "<span style='margin-left: 0px; color: red;'>*</span>";
    }

    //Short answer and Long answer
    if ($type_question == "SHORT_ANSWER" || $type_question == "LONG_ANSWER") {
      $html .= "<div style='padding: 10px; border: 2px solid rgb(229 231 235); border-radius: 6px; margin-bottom: 10px;'>";
      $html .= " <h3 style='font-size: 18px; font-weight: normal;'>$name_question $span_required_question</h3>";
      $html .= " <p style='border-bottom: 1px dashed black;'>$final_answer</p>";
      $html .= "</div>";
    }

    //Multiple choise
    if ($type_question == "MULTIPLE_CHOISE") {

      $options = $question['options'];

      $html .= "<div style='padding: 10px; border: 2px solid rgb(229 231 235); border-radius: 6px; margin-bottom: 10px;'>";
      $html .= " <h3 style='font-size: 18px; font-weight: normal;'>$name_question $span_required_question</h3>";

      foreach ($options as $option) {

        $id_option = (int)$option['id_option'];
        $name_option = $option['name_option'];
        $other_option = $option['other_option'];

        $option_checked = "";
        $final_answer_name_option =  "";
        if (isset($final_answer['id_option']) && $id_option == $final_answer['id_option']) {
          $option_checked = "checked";
          if (isset($final_answer['name_option'])) {
            $final_answer_name_option = $final_answer['name_option'];
          }
        }

        if ($other_option == 0) {
          $html .= "  <div style='margin-bottom: 10px;'>";
          $html .= "    <input type='radio' style='width: 20px; height: 20px;' $option_checked>";
          $html .= "    <span>$name_option</span>";
          $html .= "  </div>";
        } else {
          $html .= "  <div style='margin-bottom: 10px;'>";
          $html .= "    <input type='radio' style='width: 20px; height: 20px;' $option_checked>";
          $html .= "    <span>$name_option :</span>";
          $html .= "    <p style='border-bottom: 1px dashed black; width: 100%;'>$final_answer_name_option</p>";
          $html .= "  </div>";
        }
      }

      $html .= "</div>";
    }

    //Checkbox
    if ($type_question == "CHECKBOX") {

      $options = $question['options'];
      $options_checked = [];
      $name_other_option = "";

      $html .= "<div style='padding: 10px; border: 2px solid rgb(229 231 235); border-radius: 6px; margin-bottom: 10px;'>";
      $html .= " <h3 style='font-size: 18px; font-weight: normal;'>$name_question $span_required_question</h3>";

      if (is_array($final_answer) && !empty($final_answer)) {
        foreach ($final_answer as $final_answer_option) {
          $id_option_final_answer_option = $final_answer_option['id_option'];
          $other_option_final_answer_option = $final_answer_option['other_option'];
          $options_checked[$id_option_final_answer_option] = "checked";
          if ($other_option_final_answer_option == 1) {
            $name_other_option = $final_answer_option['name_option'];
          }
        }
      }

      foreach ($options as $option) {

        $id_option = (int)$option['id_option'];
        $name_option = $option['name_option'];
        $other_option = $option['other_option'];

        $option_checked = "";
        if (isset($options_checked[$id_option])) {
          $option_checked = "checked";
        }

        if ($other_option == 0) {
          $html .= "  <div style='margin-bottom: 10px;'>";
          $html .= "    <input type='checkbox' style='width: 20px; height: 20px;' $option_checked>";
          $html .= "    <span>$name_option</span>";
          $html .= "  </div>";
        } else {
          $html .= "  <div style='margin-bottom: 10px;'>";
          $html .= "    <input type='checkbox' style='width: 20px; height: 20px;' $option_checked>";
          $html .= "    <span>$name_option :</span>";
          $html .= "    <p style='border-bottom: 1px dashed black; width: 100%;'>$name_other_option</p>";
          $html .= "  </div>";
        }
      }

      $html .= "</div>";
    }

    //List
    if ($type_question == "LIST") {

      $name_option = "Choose";
      if (isset($final_answer['name_option'])) {
        $name_option = $final_answer['name_option'];
      }

      $html .= "<div style='padding: 10px; border: 2px solid rgb(229 231 235); border-radius: 6px; margin-bottom: 10px;'>";
      $html .= " <h3 style='font-size: 18px; font-weight: normal;'>$name_question $span_required_question</h3>";
      $html .= " <select>";
      $html .= "  <option selected>$name_option</option>";
      $html .= " </select>";
      $html .= "</div>";
    }
  }

  $html .= "<div style='page-break-after: always;'></div>";
}

$dompdf->loadHtml($html);

$dompdf->render();

$dompdf->addInfo("Title", $filename);

$dompdf->stream($filename, ['Attachment' => 0]);
