<?php
/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  Render.php                                                            */
/**************************************************************************/
/*                        This file is part of:                           */
/*                              daamper                                   */
/*                 https://github.com/armindeck/daamper                   */
/**************************************************************************/
/* Copyright (c) 2025 DBHS / daamper                                      */
/*                                                                        */
/* Se concede permiso, de forma gratuita, a cualquier persona para usar,  */
/* modificar y ejecutar el código fuente de este software, incluyendo su  */
/* uso en proyectos comerciales (como monetización por publicidad o       */
/* donaciones).                                                           */
/*                                                                        */
/* Restricciones estrictas:                                               */
/* - No está permitido vender, sublicenciar o distribuir el código        */
/*   fuente —total o parcialmente— con fines de lucro.                    */
/* - No está permitido convertir el código en privativo ni eliminar       */
/*   esta licencia.                                                       */
/* - No está permitido reclamar la autoría del código original.           */
/*                                                                        */
/* Uso permitido:                                                         */
/* - Se permite modificar y usar el código con fines personales,          */
/*   educativos y/o comerciales, siempre que no se venda.                 */
/* - Se permite usar este software como base para otros proyectos,        */
/*   siempre que esta licencia se mantenga.                               */
/*                                                                        */
/* El autor (DBHS / daamper) se reserva el derecho de modificar esta      */
/* licencia en futuras versiones del software.                            */
/*                                                                        */
/* EL SOFTWARE SE ENTREGA "TAL CUAL", SIN GARANTÍAS DE NINGÚN TIPO,       */
/* EXPRESAS O IMPLÍCITAS, INCLUYENDO, SIN LIMITACIÓN, GARANTÍAS DE        */
/* COMERCIABILIDAD, IDONEIDAD PARA UN PROPÓSITO PARTICULAR Y NO           */
/* INFRACCIÓN. EN NINGÚN CASO LOS AUTORES SERÁN RESPONSABLES POR          */
/* RECLAMACIONES, DAÑOS U OTRAS RESPONSABILIDADES, YA SEA EN UNA ACCIÓN   */
/* CONTRACTUAL, EXTRACONTRACTUAL O DE OTRO TIPO, DERIVADAS DE O EN        */
/* CONEXIÓN CON EL SOFTWARE, SU USO O OTRO TIPO DE MANEJO.                */
/**************************************************************************/

namespace Core;

class Render {
    public function inputCheck(array $data): string {
        extract($data, EXTR_SKIP);

        return '<div class="inputs-checkbox">'.
            '<input type="checkbox" name="' . ($name ?? "show") . '" id="check-enable-' . ($id ?? "show") . '"' . (!empty($checked) ? " checked" : "") . '>'.
            '<label for="check-enable-' . ($id ?? "show") . '">'.
                '<div class="icon icon--left">'.
                    '<span class="inactive"><i class="' . ($icon_inactive ?? "far fa-circle") . '"></i></span>'.
                    '<span class="active"><i class="' . ($icon_active ?? "far fa-check-circle") . '"></i></span>'.
                '</div>'.
                '<div class="text">' . (empty($escape_title) ? (Language($title ?? "") ?? $title ?? "") : ($title ?? "")) . '</div>'.
            '</label>'.
        '</div>';
    }

    public function input(array $data): string {
        extract($data, EXTR_SKIP);

        return '<input type="' . ($type ?? "text") . '" name="' . ($name ?? "") . '" title="' . (empty($escape_title) ? (Language($title ?? "") ?? $title ?? "") : ($title ?? "")) . '" placeholder="' . (empty($escape_placeholder) ? Language($placeholder ?? "") : ($placeholder ?? "")) . '" class="' . ($class ?? "") . '"' . (!empty($min) || isset($min) ? " min=\"$min\"" : "") . (!empty($max) ? " max=\"$max\"" : "") . ' value="' . (htmlspecialchars($value ?? "")) . '"' . (!empty($required) ? " required" : "") . '>';
    }

    public function inputLink(array $data = ["name" => "", "text" => "", "url" => "", "icon" => "", "icon_position" => 0, "class" => "", "external" => 0, "hidden" => 0]): string {
        extract($data, EXTR_SKIP);
        $render = "";

        $render .= $this->input([
            "name" => ($name ?? "") . "_text",
            "value" => $text ?? "",
            "title" => "text",
            "placeholder" => "text",
        ]);

        $render .= $this->input([
            "name" => ($name ?? "") . "_url",
            "value" => $url ?? "",
            "title" => "url",
            "placeholder" => "url",
        ]);

        $render .= $this->input([
            "name" => ($name ?? "") . "_icon",
            "value" => $icon ?? "",
            "title" => "icon",
            "escape_placeholder" => true,
            "placeholder" => "fas fa-home",
        ]);

        $render .= $this->select([
            "name" => ($name ?? "") . "_icon_position",
            "title" => "icon-position",
            "selected" => $icon_position ?? "",
            "option" => ["" => "icon-position", 0 => "left", 1 => "right"],
        ]);

        $render .= $this->input([
            "name" => ($name ?? "") . "_class",
            "value" => $class ?? "",
            "title" => "class",
            "escape_placeholder" => true,
            "placeholder" => "boton-2",
        ]);

        $render .= $this->inputCheck([
            "name" => ($name ?? "") . "_external",
            "id" => ($name ?? "") . "_external",
            "title" => "external",
            "checked" => $external ?? "",
        ]);

        $render .= $this->inputCheck([
            "name" => ($name ?? "") . "_hidden",
            "id" => ($name ?? "") . "_hidden",
            "title" => "hidden",
            "checked" => $hidden ?? "",
        ]);

        return $render;
    }

    public function linkContruct(array $data = ["text" => "", "url" => "", "icon" => "", "icon_position" => 0, "class" => "", "external" => 0, "hidden" => 0, "Template" => null, "directory" => "", "unique" => ""]): string {
        extract($data, EXTR_SKIP);
        
        if(!empty($hidden)){ return ""; }
        
        if(!empty($Template)){
            $text = $Template->commands($text ?? "", 0, 0, $this);
            $url = $Template->commands($url ?? "", 0, 0, $this);
        }


        $convert = trim(str_replace([" ", "_"], "-", strtolower($text ?? "")));
        $render_icon = function () use ($icon, $icon_position, $text, $unique): string {
            $icon_position_class = !empty($icon_position) ? "icon--right" : "icon--left";
            $icon_position_add = !empty($text) && empty($unique) ? " $icon_position_class" : "";
            
            $html  = '<span class="icon' . ($icon_position_add) . '"><i class="' . ($icon ?? "") . '"></i></span>';

            return (empty($unique) || $unique == "icon") && !empty($icon) ? $html : "";
        };

        $render_url = function ($url, $directory): string {
            $strl = trim(strtolower($url));
            $count = mb_strlen($url);
            $isThis = $count > 0 && in_array(substr($strl, 0, 1), ["?", "#"]);
            $isHttp = $count > 7 && substr($strl, 0, 7) == "http://";
            $isHttps = $count > 8 && substr($strl, 0, 8) == "https://";
            $isUrl = $isThis || $isHttp || $isHttps;
            
            if($isUrl || empty($directory)){ return $url; } // Is url 😮
            
            return $directory . $url; // ./home, ../home, ../../home?view=main
        };
        
        $render = '<a href="' . $render_url($url ?? "", $directory ?? "") . '"'; // url
        $render .= !empty($external) ? ' target="_blank"' : ''; // Target blank
        $render .= !empty($class) ? ' class="' . $class . '"' : ''; // Class
        $render .= '>';
        $render .= empty($icon_position) ? $render_icon() : ""; // Icon left
        $render .= (empty($unique) || $unique == "text") && !empty($text) ? '<span class="text">' . (Language($convert) ?? $text ?? "") . '</span>' : ""; // Text - translate
        $render .= !empty($icon_position) ? $render_icon() : ""; // Icon right
        $render .= '</a>';

        return $render;
    }

    private function linkSearchAutomatic(string $name, array $array): array {
        $list = ["text", "url", "icon", "icon_position", "class", "external", "hidden"];
        $data = ["name" => $name];
        
        foreach ($list as $value) {
            $data[$value] = $array["{$name}_{$value}"] ?? "";
        }
        return $data;
    }

    public function linkRenderSearchAutomatic(string $name, array $array, ?array $id = ["container" => 0, "element" => 0, "Template" => null, "directory" => "", "unique" => ""]): string {
        $name = "{$name}_link_c_{$id['container']}_e_{$id['element']}";
        return $this->linkContruct(array_merge($this->linkSearchAutomatic($name, $array), ["Template" => $id['Template'], "directory" => $id['directory'] ?? "", "unique" => $id['unique'] ?? ""]));
    }

    public function linkRenderSearchAutomaticAll(string $name, array $array, ?array $id = ["container" => 0, "element" => 0, "Template" => null, "directory" => "", "unique" => ""]): string {
        $name = "{$name}_link_c_{$id['container']}_e_{$id['element']}";
        $quantity = $name . "_quantity";
        if(!isset($array[$quantity]) || empty($array[$quantity]) || !is_numeric($array[$quantity]) || $array[$quantity] < 1){
            $array[$quantity] = 1;
        }
        $render = "";
        for ($i = 1; $i <= $array[$quantity]; $i++) {
            $newName = $name . "_{$i}";
            $render .= $this->linkContruct(array_merge($this->linkSearchAutomatic($newName, $array), ["Template" => $id['Template'], "directory" => $id['directory'] ?? "", "unique" => $id['unique'] ?? ""]));
        }
        return $render;
    }

    public function modalInputLinkSearchAutomatic(string|null $title, string $name, array $array, ?array $id = ["container" => 0, "element" => 0], ?int $i = null, ?bool $createInputTitle = true): string {
        $name = "{$name}_link_c_{$id['container']}_e_{$id['element']}" . (!is_null($i) ? "_{$i}" : "");
        $title = !empty($title) ? $title : (!empty($array["{$name}_text"]) ? $array["{$name}_text"] : "link");
        $title_convert = trim(str_replace([" ", "_"], "-", strtolower($title)));

        $render = "";

        if($createInputTitle){
            $title_details = (!empty($array["{$name}_title"]) ? $array["{$name}_title"] : "title");
            $title_details_convert = trim(str_replace([" ", "_"], "-", strtolower($title_details)));

            $render .= '<details><summary><strong>' . (Language($title_details_convert) ?? $title_details) . ':</strong></summary><section class="flex">';
            $render .= $this->input([
                "title" => "title",
                "name" => "{$name}_title",
                "value" => ($array["{$name}_title"] ?? ""),
                "placeholder" => "title",
                "class" => "flex-1"
            ]);
            $render .= "</section><hr></details>";
        }

        $render .= $this->modal([
            "escape_title" => true,
            "title" => Language($title_convert) ?? $title,
            "id" => $name ?? "",
            "content" => $this->inputLink($this->linkSearchAutomatic($name, $array)),
            "checked" => false
        ]);

        return $render;
    }

    public function modalInputLinkSearchAutomaticQuantity(string|null $title, string $name, array $array, ?array $id = ["container" => 0, "element" => 0]): string {
        // (social)_link_container_$_element_$_quantity
        // (social)_link_container_$_element_$_id_$_(text,url,icon,icon_position,external,hidden)
        
        $link_container_element = "link_c_{$id['container']}_e_{$id['element']}";
        // link_c_$_e_$

        $name_title_details = "{$name}_{$link_container_element}_title";
        // (name)_link_c_$_e_$title

        $name_quantity = "{$name}_{$link_container_element}_quantity";
        // (name)_link_c_$_e_$_quantity

        $title_details = (!empty($array["$name_title_details"]) ? $array["$name_title_details"] : "title");
        $title_details_convert = trim(str_replace([" ", "_"], "", strtolower($title_details)));

        $render = "";

        $render .= '<details><summary><strong>' . (Language($title_details_convert) ?? $title_details) . ':</strong></summary><section class="flex flex-column">';
            $render .= $this->input([
                "title" => "title",
                "name" => $name_title_details,
                "value" => ($array[$name_title_details] ?? ""),
                "placeholder" => "title",
                "class" => "flex-1"
            ]);

            $render .= '<label class="flex flex-between gap-8 items-center"><span>' . Language("quantity") . ':</span>';
            $render .= $this->input([
                "title" => "quantity",
                "type" => "number",
                "min" => 1,
                "max" => 50,
                "name" => $name_quantity,
                "value" => ($array[$name_quantity] ?? 1),
                "placeholder" => "quantity"
            ]);
            $render .= "</label>";
            
        $render .= "</section><hr></details>";
        
        for ($i = 1; $i <= ($array[$name_quantity] ?? 1); $i++) {
            $render .= $this->modalInputLinkSearchAutomatic($title ?? "", $name, $array, $id, $i, false);
        }
        
        return $render;
    }

    public function textarea(array $data): string {
        extract($data, EXTR_SKIP);

        return '<textarea name="' . ($name ?? "") . '" title="' . (empty($escape_title) ? Language($title ?? "") : ($title ?? "")) . '" placeholder="' . (empty($escape_placeholder) ? Language($placeholder ?? "") : ($placeholder ?? "")) . '" class="' . ($class ?? "") . '"' . (!empty($minlenght) || isset($minlenght) ? " minlenght=\"$minlenght\"" : "") . (!empty($maxlenght) ? " maxlenght=\"$maxlenght\"" : "") . (!empty($rows) ? " rows=\"$rows\"" : "") . (!empty($cols) ? " cols=\"$cols\"" : "") . (!empty($required) ? " required" : "") . '>' . (htmlspecialchars($text ?? "")) . '</textarea>';
    }

    public function select(array $data): string {
        extract($data, EXTR_SKIP);

        $render = '<select name="' . ($name ?? "") . '" title="' . (empty($escape_title) ? (Language($title ?? "") ?? $title ?? "") : ($title ?? "")) . '" class="' . ($class ?? "") . '"' . (!empty($required) ? " required" : "") . '>';
        if(!empty($option) && is_array($option)):
            $unique_value = $unique_value ?? false;
            foreach ($option as $key => $value):
                $render .= '<option ';
                $render .= empty($unique_value) ? 'value="' . ($key) . '"' : "";
                $render .= (!empty($selected) && $selected == ($unique_value ? $value : $key) ? " selected" : "");
                $render .= '>' . (empty($escape_option_translate) ? Language($value ?? "text") : ($value ?? "")) . '</option>';
            endforeach;
        endif;

        $render .= '</select>';
        return $render;
    }

    public function modal(array $data): string {
        extract($data, EXTR_SKIP);

        $render = '<input type="checkbox" class="check-modal" id="modal-' . ($id ?? "empty") . '" hidden>'.
        '<div class="modal' . (!empty($class) ? " " . $class : "") . '">'.
            '<label for="modal-' . ($id ?? "empty") . '" class="modal__header">'.
                '<span class="icon"><i class="fas fa-chevron-circle-right"></i></span>'.
                '<span>' . (empty($escape_title) ? (Language($title) ?? $title) : ($title ?? "")) . '</span>'.
	        '</label>';
            if(!empty($option) || !empty($content)):
                $render .= '<section class="modal__main">'.
                    '<nav>'.
                        '<header>'.
                            '<label for="modal-' . ($id ?? "empty") . '" class="modal__header">'.
                                '<span class="icon"><i class="fas fa-times"></i></span>'.
                                '<span>' . (Language("close") ?? "Cerrar") . '</span>'.
                            '</label>'.
                        '</header>';
                        $render .= (!empty($content) ? '<section>' . (is_callable($content) ? $content() : $content) . '</section>' : '');
                        if(!empty($option) && is_array($option)):
                            foreach ($option ?? [] as $value):
                                $render .= '<label>'.
                                    '<input type="checkbox" name="' . ($value["name"] ?? "") . '" value="' . ($value["value"] ?? "") . '" ' . (!empty($value["checked"]) ? "checked " : "") . 'hidden>'.
                                    '<span class="icon ' . (!empty($value["title"]) ? "icon--left" : "") . '">'.
                                        '<span class="inactive"><i class="' . ($button_right_icon_inactive ?? "far fa-circle") . '"></i></span>'.
                                        '<span class="active"><i class="' . ($button_right_icon_active ?? "far fa-check-circle") . '"></i></span>'.
                                    '</span>'.
                                    '<span>'. (empty($value["escape_title"]) ? (Language($value["title"]) ?? $value["title"]) : ($value["title"] ?? "")) . '</span>'.
                                '</label>';
                            endforeach;
                        endif;
                    $render .= '</nav>'.
                '</section>';
            endif;
        $render .= '</div>';
        return $render;
    }

    public function dropdown(array $data): string {
        extract($data, EXTR_SKIP);

        $render = !empty($before) ? (is_callable($before) ? $before() : $before) : "";
        if(!empty($show) || !isset($show)):
            $render .= '<input type="checkbox" class="check-dropdown" id="check-show-' . ($id ?? "empty") . '" ' . (!empty($checked) ? "checked" : "") . ' hidden>'.
            '<div class="dropdown">'.
                '<header class="dropdown__header">'.
                    '<label for="check-show-' . ($id ?? "empty") . '">'.
                        '<span class="icon' . (!empty($title) ? " icon--left" : "") .'">'.
                            '<span class="inactive"><i class="' .($button_menu_icon_inactive ?? "fas fa-bars") . '"></i></span>'.
                            '<span class="active"><i class="' . ($button_menu_icon_active ?? "fas fa-times"). '"></i></span>'.
                        '</span>'.
                        '<strong>' . (empty($escape_title) ? Language($title ?? "text") : ($title ?? "")) . '</strong>'.
                    '</label>'.
                    '<div class="flex items-center">';
                        if(!empty($button_right_show)):
                            $render .= '<div class="inputs-checkbox flex gap-0">'.
                            '<input type="checkbox" name="' . ($button_right_name ?? "show") . '" id="check-enable-' . ($button_right_id ?? "show") . '" ' . (!empty($button_right_checked) ? "checked" : "") . '>'.
                            '<label for="check-enable-' . ($button_right_id ?? "show") .'">'.
                                '<div class="icon' . (!empty($button_right_text) ? " icon--left" : "") . '">'.
                                    '<span class="inactive"><i class="' . ($button_right_icon_inactive ?? "far fa-circle") . '"></i></span>'.
                                    '<span class="active"><i class="' . ($button_right_icon_active ?? "far fa-check-circle") . '"></i></span>'.
                                '</div>'.
                                '<div class="text">' . (Language($button_right_text ?? "show")) . '</div>'.
                            '</label>'.
                        '</div>';
                        endif;
                    $render .= '</div>'.
                '</header>'.
                '<section class="dropdown__main">'.
                    '<div class="dropdown_content">'.
                        (!empty($content_before) ? (is_callable($content_before) ? $content_before() : $content_before) : "").
                        (!empty($content) ? (is_callable($content) ? $content() : $content) : "").
                        (!empty($content_after) ? (is_callable($content_after) ? $content_after() : $content_after) : "").
                    '</div>'.
                '</section>'.
            '</div>';
        endif;
        $render .= !empty($after) ? (is_callable($after) ? $after() : $after) : "";

        return $render;
    }
}