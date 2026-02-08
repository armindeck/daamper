<?php // Dashboard
use Core\Render;
$render = new Render;
$data = Daamper::$data->Config("admin"); // Data
$user_rol = strtolower($_SESSION["rol"]); // Rol
$rules = $data["rules"] ?? []; // Roles

// Capture section
$ap = !empty($_GET["ap"]) ? Daamper::$scripts->normalizar2($_GET["ap"]) : "";

// Wellcome
$wellcome = (string) empty($ap) ? "<h3>" . Language("wellcome-dashboard") . "</h3><br><p>" . Language("wellcome-dashboard-text") . "</p><hr>" : "";

// View file
$view = __DIR__ . "/../admin/{$ap}-view.php";

echo "<div class=\"flex flex-column gap-4\" style=\"max-width: 920px; padding: 8px; margin: auto;\">";

// Section not found
echo !empty($ap) && !file_exists($view) ? "<p class=\"con\">" . (Language("section-not-found-or-under-construction", 'global', ['value' => "<strong>$ap</strong>"])) . "</p>" : "";

// Higher role required - El global redirige, asi que no se muestra
echo !empty($ap) && file_exists($view) && !in_array($ap, $rules[$user_rol]) ? "<p class=\"con\">" . (Language("higher-role-required")) . "</p>" : "";


$content = (string) $wellcome; // Content accordion

$content .= "<div class=\"flex flex-column-mobil botones-2\">";

// Section list by rules
if (isset($rules[$user_rol])) {
  foreach ($data["entries"] ?? [] as $key => $value) {
    if(in_array($value['section'], $rules[$user_rol])) { // Verify entrie
      // Entry button
      $content .= "<a href=\"?ap={$value['section']}\"><span class=\"icon icon--left\"><i class=\"{$value['icon']}\"></i></span><span class=\"text\">" . Language($value['text']) . "</span></a>";
    }
  }
}
$content .= "</div>";

echo $render->dropdown([
  "id" => "admin-entries",
  "title" => "dashboard-sections",
  "content" => $content,
  "checked" => (empty($ap) ? true : (!file_exists($view) ? true : false)),
]);

echo "</div>";

// Show section
if (isset($rules[$user_rol]) && in_array($ap, $rules[$user_rol]) && file_exists($view)){
  $Form = new helpers\Form;

  // Templates
  $admin_contruct = (array) [
    "input_and_label_class" => [
      "class" => "flex-1 max-w-50p-min-tablets w-100p-mobil",
      "label_class" => "flex flex-between flex-column-mobil items-center-min-tablets",
      "label_value_class" => "w-100p-mobil", "required" => true
    ],
    "select_false_or_true" => [Language("no"), Language("yes")],
    "accordion" => [
      "type" => "form",
      "parent_tags" => 'method="post" action="process/actions.php"',
      "after_class" => "mr-y-16",
      "checked" => true,
      "before_content" => '<nav class="flex-column gap-4">',
      "after_content" => '</nav>',
    ]
  ];
  
  echo "<hr>";
  echo "<div class=\"flex flex-column gap-8\" style=\"max-width: 920px; padding: 8px; margin: auto;\">";
  //require_once $view;
  Daamper::view("admin/$ap", ["input" => $Form, "render" => $render, "admin_contruct" => $admin_contruct]);
  echo "</div>";
}
?>
