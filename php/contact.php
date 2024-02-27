<?php
// -------------------------------------------------------------------------------------
// EXÉCUTÉ À LA 1e INSTANCE DU FORMULAIRE (affichage initial) : 
  $array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "message" => "",
  "firstnameError" => "", "nameError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", 
  "isSuccess" => false);
  $emailTo = "ephalia@orange.fr";

// -------------------------------------------------------------------------------------
// EXÉCUTÉ À LA 2e INSTANCE DU FORMULAIRE (après soumission) : 
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pré-traitement / nettoyage des données (sécurité) :
    $array["firstname"] = verifyInput($_POST["firstname"]);
    $array["name"] = verifyInput($_POST["name"]);
    $array["email"] = verifyInput($_POST["email"]);
    $array["phone"] = verifyInput($_POST["phone"]);
    $array["message"] = verifyInput($_POST["message"]);
    $array["isSuccess"] = true;
    $emailText = "";
   
    // Si non validation des champs obligatoires : message d'erreur
    if (empty($array["firstname"])){
      $array["firstnameError"] = "J'aimerais connaître votre prénom !";
      $array["isSuccess"] = false;
    } else {
      $emailText .= "Firstname : {$array["firstname"]}\n";
    }
    if (empty($array["name"])){
      $array["nameError"] = "Merci de renseigner votre nom !";
      $array["isSuccess"] = false;
    } else {
      $emailText .= "Name : {$array["name"]}\n";
    }
    if (empty($array["message"])){
      $array["messageError"] = "Que voulez-vous me dire ?";
      $array["isSuccess"] = false;
    } else {
      $emailText .= "Message : {$array["message"]}\n";
    }

    // Si non validation du format de l'email : message d'erreur
    if (!isEmail($array["email"])){ // si isEmail ne renvoie pas true
      $array["emailError"] = "Ceci n'est pas un email !";
      $array["isSuccess"] = false;
    } else {
      $emailText .= "E-mail : {$array["email"]}\n";
    }

    // Si non validation du format de tél : message d'erreur
    if (!isPhone($array["phone"])){ // si isPhone ne renvoie pas true
      $array["phoneError"] = "Uniquement des chiffres et des espaces, svp...";
      $array["isSuccess"] = false;
    } else {
      $emailText .= "Phone : {$array["phone"]}\n";
    }

    // envoi de l'e-mail avec les données ;
    if($array["isSuccess"]){
      $headers = "From: {$array["firstname"]} {$array["name"]} <{$array["email"]}>\r\nReply-To: {$array["email"]}";
      mail($emailTo, "Un message de votre site", $emailText, $headers);
    }
  }

  echo json_encode($array);

  function isEmail($var){
    // Vérification si format de l'email est valide :
    return filter_var($var, FILTER_VALIDATE_EMAIL);
  }

  function isPhone($var){
    // Vérification si format du tél est valide :
    return preg_match("/^[0-9 ]*$/", $var);
  }

  function verifyInput($var){
    // Nettoyage des données (suppression éventuel code malveillant) :
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);
    return $var;
  }
