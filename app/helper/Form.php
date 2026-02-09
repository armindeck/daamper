<?php

/**************************************************************************/
/*  Licencia de Uso No Transferible - daamper                             */
/**************************************************************************/
/*  Form.php                                                              */
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

namespace helpers;

class Form {
    public function submit(array $values = ["name" => "", "value" => ""]) : string {
        $values["type"] = "submit";
        $values["class"] = $values["class"] ?? "button";
        $values["name"] = $values["name"] ?? "";
        return $this->text($values);
    }

    public function text(array $values = ["name" => "", "type" => "text", "value" => ""]) : string {
        $values["type"] = $values["type"] ?? "text";
        $values["value"] = htmlspecialchars($values["value"] ?? "", ENT_QUOTES, 'UTF-8');
        $extruct = $this->extruct($values);
        $before = $values["before"] ?? "";
        $after = $values["after"] ?? "";

        return "{$before}<input {$extruct}>{$after}";
    }

    public function textarea(array $values = ["name" => "", "class" => "text", "value" => ""]) : string {
        $value = htmlspecialchars($values["value"] ?? "", ENT_QUOTES, 'UTF-8');
        $values["class"] = $values["class"] ?? "block min-w-100p max-w-100p";
        unset($values["value"]);
        
        $extruct = $this->extruct($values);
        $before = $values["before"] ?? "";
        $after = $values["after"] ?? "";

        return "{$before}<textarea {$extruct}>{$value}</textarea>{$after}";
    }

    public function select(array $values = ["name" => "", "option" => ["key" => "value"], "class" => "", "style" => "", "id" => "", "selected" => "", "default" => false]) : string {
        $extruct = $this->extruct($values);

        $before = $values["before"] ?? "";
        $after = $values["after"] ?? "";
        $only_value = $values["only_value"] ?? false;

        $option = "";
        foreach (($values["option"] ?? []) as $key => $content) {
            $key2 = $key;
            if($only_value){ $key2 = $content; }
            $option .= "<option value=\"{$key2}\"" . (!empty($values["selected"]) && $values["selected"] == $key2 ? " selected" : "") . ">{$content}</option>";
        }

        return "{$before}<select {$extruct}>{$option}</select>{$after}";
    }

    public function label(array $values = ["for" => "", "content" => "", "class" => "", "style" => "", "hidden" => false]){
        $extruct = $this->extruct($values);
        
        $content = $values["content"] ?? "";
        $before = $values["before"] ?? "";
        $after = $values["after"] ?? "";
        
        $value_class = !empty($values["value_class"] ?? "") ? "class=\"{$values['value_class']}\" " : "";
        $value_style = !empty($values["value_style"] ?? "") ? "style=\"{$values['value_style']}\" " : "";
        $value_hidden = !empty($values["value_hidden"]) ? "hidden" : "";
        $before_content = $values["before_content"] ?? "";
        $after_content = $values["after_content"] ?? "";
        $value_before_content = $values["value_before_content"] ?? "";
        $value_after_content = $values["value_after_content"] ?? "";

        return "{$before}<label {$extruct}>{$before_content}<span {$value_class}{$value_style} $value_hidden>{$value_before_content}{$content}{$value_after_content}</span>{$after_content}</label>{$after}";
    }

    public function labelText(array $values = ["type" => "text", "name" => "", "value" => "", "label_class" => "", "label_for" => ""]) : string {
        $values["label_value_after_content"] = $values["label_value_after_content"] ?? ":";
        $label = $this->labelValues($values);
        $label = str_replace("</label>", "", $label);
        
        return $label . $this->text($values) . "</label>";
    }

    public function labelTextarea(array $values = ["rows" => 5, "cols" => 33, "name" => "", "value" => "", "label_class" => "", "label_for" => ""]) : string {
        $values["label_value_after_content"] = $values["label_value_after_content"] ?? ":";
        $label = $this->labelValues($values);
        $label = str_replace("</label>", "", $label);
        
        return $label . $this->textarea($values) . "</label>";
    }

    public function labelSelect(array $values = ["name" => "", "value" => "", "label_class" => "", "label_for" => ""]) : string {
        $values["label_value_after_content"] = $values["label_value_after_content"] ?? ":";
        $label = $this->labelValues($values);
        $label = str_replace("</label>", "", $label);
        
        return $label . $this->select($values) . "</label>";
    }

    private function labelValues(array $values = ["label_for" => "", "label_content" => "", "label_class" => "", "label_style" => "", "label_hidden" => false]) : string {
        $content = [
            "for" => $values["label_for"] ?? "",
            "content" => $values["label_content"] ?? "",
            "class" => $values["label_class"] ?? "",
            "style" => $values["label_style"] ?? "",
            "title" => $values["label_title"] ?? "",
            "before" => $values["label_before"] ?? "",
            "after" => $values["label_after"] ?? "",
            "hidden" => $values["label_hidden"] ?? false,
            "value_class" => $values["label_value_class"] ?? "",
            "value_style" => $values["label_value_style"] ?? "",
            "before_content" => $values["label_before_content"] ?? "",
            "after_content" => $values["label_after_content"] ?? "",
            "value_hidden" => $values["label_value_hidden"] ?? false,
            "value_before_content" => $values["label_value_before_content"] ?? "",
            "value_after_content" => $values["label_value_after_content"] ?? "",
        ];
        
        return $this->label($content);
    }

    private function extruct(array $values = ["type" => "", "name" => "", "value" => ""]): string {
        $type = !empty($values["type"] ?? "") ? "type=\"{$values['type']}\" " : "";
        $name = !empty($values["name"] ?? "") ? "name=\"{$values['name']}\" " : "";
        $value = !empty($values["value"] ?? "") ? "value=\"{$values['value']}\" " : "";
        $class = !empty($values["class"] ?? "") ? "class=\"{$values['class']}\" " : "";
        $id = !empty($values["id"] ?? "") ? "id=\"{$values['id']}\" " : "";
        $style = !empty($values["style"] ?? "") ? "style=\"{$values['style']}\" " : "";
        $title = !empty($values["title"] ?? "") ? "title=\"{$values['title']}\" " : "";
        $placeholder = !empty($values["placeholder"] ?? "") ? "placeholder=\"{$values['placeholder']}\" " : "";
        $min = !empty($values["min"] ?? "") ? "min=\"{$values['min']}\" " : "";
        $max = !empty($values["max"] ?? "") ? "max=\"{$values['max']}\" " : "";
        $minlength = !empty($values["minlength"] ?? "") ? "minlength=\"{$values['minlength']}\" " : "";
        $maxlength = !empty($values["maxlength"] ?? "") ? "maxlength=\"{$values['maxlength']}\" " : "";
        $required = !empty($values["required"]) ? "required" : "";
        $checked = !empty($values["checked"]) ? "checked" : "";
        $hidden = !empty($values["hidden"]) ? "hidden" : "";
        $disabled = !empty($values["disabled"]) ? "disabled" : "";
        $readonly = !empty($values["readonly"]) ? "readonly" : "";

        // File
        $accept = !empty($values["accept"] ?? "") ? "accept=\"{$values['accept']}\" " : "";

        // Label
        $for = !empty($values["for"] ?? "") ? "for=\"{$values['for']}\" " : "";

        // Textarea
        $rows = !empty($values["rows"] ?? "") ? "rows=\"{$values['rows']}\" " : "";
        $cols = !empty($values["cols"] ?? "") ? "cols=\"{$values['cols']}\" " : "";

        return "{$type}{$name}{$value}{$class}{$id}{$style}{$title}{$placeholder}{$min}{$max}{$minlength}{$maxlength}{$accept}{$for}{$rows}{$cols} {$required} {$checked} {$hidden} {$disabled} {$readonly}";
    }
}