<?php

namespace Systeme\HTML;

use Systeme;

class Form
{
    private function surround ($data, $addLabel = true, $element = 'p')
    {
        $id = $data[0];
        $input = $data[1];
        $label = ($addLabel)? $data[2] : null;

        $html = '<' .$element. ' class="formSurround">';

        if ($addLabel) {
            $html .= '<label for="' .$id. '">';
            $html .= $label;
            $html .= '</label>';
        }

        $html .= $input;
        $html .= '</' .$element. '>';

        return $html;
    }

    public function input ($datas, $addLabel = true)
    {
        $id = uniqid();
        $required = (isset($datas['required']) && $datas['required'] == false)? null : 'required';
        $checked = (isset($datas['checked']) && $datas['checked'])? 'checked ' : null;
        $type = $datas['type'];
        $name = $datas['name'];
        $placeholder = (isset($datas['ph']))? $datas['ph'] : null;
        $value = (isset($datas['value']))? $datas['value'] : null;
        $accept = (isset($datas['accept']))? 'accept="' .$datas['accept']. '" '  : null;
        $src = (isset($datas['src']))? 'src="' .$datas['src']. '" ' : null;
        $limit = (isset($datas['max']))? 'maxlength="' .$datas['max']. '"' : null;

        $html = '<input ' .$required. ' id="' .$id. '" ';
        $html .= 'type="' .$type. '" ';
        $html .= 'name="' .$name. '" ';
        $html .= ($type === 'datetime-local')? $this->datetimeInput($value) : null;
        $html .= ($addLabel === false)? 'placeholder="'. $placeholder .'" ' : null;
        $html .= ($value !== null)? 'value="' .$value. '" ' : null;
        $html .= $src;
        $html .= $accept;
        $html .= $checked;
        $html .= $limit;
        $html .= '/>';

        return $this->surround([$id, $html, $placeholder], $addLabel);
    }

    public function textarea ($datas, $addLabel = false)
    {
        $id = uniqid();
        $required = (isset($datas['required']))? null : 'required';
        $name = $datas['name'];
        $placeholder = (isset($datas['ph']))? $datas['ph'] : null;
        $value = (isset($datas['value']))? $datas['value'] : null;

        $html = '<textarea ' .$required. ' id="' .$id. '"';
        $html .= 'name="' .$name. '" ';
        $html .= ($addLabel === false)? 'placeholder="'. $placeholder .'" >' : '>';
        $html .= $value;
        $html .= '</textarea>';

        return $this->surround([$id, $html, $placeholder], $addLabel);
    }

    public function radio ($name, $value, $text, $default = false)
    {
        $id = uniqid();
        $required = (isset($datas['required']))? null : 'required';

        $html = '<input type="radio" id="' .$id. '" ';
        if ($default === true) {
            $html .= 'checked ';
        }
        $html .= 'value="' .$value. '" ';
        $html .= 'name="' .$name. '" ';
        $html .= '/>';
        
        $label = '<label for=' .$id. '>';
        $label .= $text;
        $label .= '</label>';

        return $html . $label;
    }

    /**
     * @param $name
     * @param $opt ['optGroup' => [['name' => 'value'], ['name' => 'value']]]
     * @param $optGroup ['label'];
     */
    public function select ($datas, $opt, $optGroup, $addLabel = false)
    {
        $id = uniqid();
        $required = (isset($datas['required']))? null : 'required';
        $name = $datas['name'];
        $placeholder = (isset($datas['ph']))? $datas['ph'] : null;
        $selected = (isset($datas['selected']))? $datas['selected'] : null;

        $html = '<select ' .$required. ' id="' .$id. '" ';
        $html .= 'name="' .$name. '">';
        
        foreach ($optGroup as $label) {
            $html .= $this->optGroup($label, $opt[$label], $selected);
        }

        $html .= '</select>';

        return $this->surround([$id, $html, $placeholder], $addLabel);
    }

    private function optGroup ($label, $options, $selected)
    {
        $html = '<optgroup label="' .Systeme::specialUcFirst($label). '">';

        for ($i = 0; $i < count($options); $i++) {
            $html .= $this->opt($options[$i], $selected);
        }
        
        $html .= '</optgroup>';

        return $html;
    }

    private function opt ($options, $selected)
    {
        $html = '';

        foreach ($options as $name => $value) {
            if ($selected == $name) {
                $html .= '<option value="' .$name. '" selected>' .Systeme::specialUcFirst($value). '</option>';
            } else {
                $html .= '<option value="' .$name. '">' .Systeme::specialUcFirst($value). '</option>';
            }
        }

        return $html;
    }

    private function datetimeInput ($value = null)
    {
        $date = Systeme::dateFormat('datetime', $value);
        $currentDate = ($value === null)? Systeme::dateFormat('datetime', time()) : $date;
        $min = Systeme::dateFormat('datetime', time());

        return 'value="' .$currentDate. '" min="' .$min. '"';
    }

    /**
     * @param $datas - [btn, name, text/img, value (option)]
     * @param $form - For formaction
     * 
     * @return string 
     */
    public function button ($datas, $form = null)
    {
        $btn = $datas['btn'];
        $name = 'name="' .$datas['name']. '" ';
        $text = (isset($datas['text']))? $datas['text'] : null;
        $value = (isset($datas['value']))? 'value="' .$datas['value']. '" ' : null;
        $img = (isset($datas['img']))? '<img src="' .$datas['img']. '" />' : null;

        $html = '<button type="submit" class="button-' .$btn. '" ';
        $html .= $value . $name;
        $html .= (!is_null($form))? 'formaction="' .$form. '"' : null;
        $html .= '>';
        $html .= (is_null($img))? $text : $img;
        $html .= '</button>';

        return $html;
    }
}