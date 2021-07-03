<?php

class HTMLElement{
	public static function Input(Array $i=[]){
		$ms = isset($i['class'])?array_shift($i):'col-12';
		foreach($i as $j):self::SingleInput($j, $ms);endforeach;
	}

	public static function SingleInput(Array $get=[], $ms=''){
		extract($get);
		$title=$title??NULL;
		$local_title=str_replace(' ','_',strtolower($title));
		$set=[
			'type'=>$type??'text',
			'title'=>$title,
			'name'=>$name??$local_title,
			'id'=>$id??$local_title,
			'value'=>$value??NULL,
			'class'=>$class??$ms??'col-12',
			'inputClass'=>$inputClass??'form-control',
			'placeholder'=>$placeholder??$title??NULL,
			'style'=>$style??NULL,
			'required'=>$required??NULL,
			'readonly'=>$readonly??NULL,
			'option'=>$option??NULL,
		];
		unset($get);
		extract($set);

		if(!empty($required) && $required=='required'){
			$star="<sup class='text-danger'><b>*</b></sup>";
			$required='required';
		}else{
			$star=NULL;
			$required=NULL;
		}

		$style = !empty($style)?'style="'.$style.'"':NULL;
		$readonly = !empty($readonly) && $readonly=='readonly'?"readonly":NULL;
		$disabled = !empty($disabled) && $disabled=='disabled'?"disabled":NULL;

		switch ($type) {
			case 'select': self::Select($title, $name, $id, $option, $class, $inputClass, $style, $star, $required, $readonly, $disabled); break; 
			case 'textarea': self::Textarea($title, $name, $id, $value, $placeholder, $class, $inputClass, $style, $star, $required, $readonly, $disabled); break;
			default: self::Text($title, $type, $name, $id, $value, $placeholder, $class, $inputClass, $style, $star, $required, $readonly, $disabled);
		}
	}
	private static function Select($title, $name, $id, $option, $class, $inputClass, $style, $star, $required, $readonly, $disabled){
        echo "<div class='$class'>
				<div class='mb-3'>
					<label for='$id' class='form-label'>$title$star</label>
					<select name='$name' id='$id' class='$inputClass' $style $required $readonly $disabled>";
						if(is_array($option)):
							echo "<option value=''>-- Please Select --</option>";
							foreach ($option as $k=>$v):
								echo "<option value='$k'>$v</option>";
							endforeach;
						endif;
						echo"
					</select>
				</div>
			</div>";
    }
	private static function Textarea($title, $name, $id, $value, $placeholder, $class, $inputClass, $style, $star, $required, $readonly, $disabled){
        $value=!empty($value)?$value:NULL;
		echo "<div class='$class'>
					<div class='mb-3'>
						<label for='$id' class='form-label'>$title$star</label>
						<textarea name='$name' id='$id' placeholder='$placeholder' class='$inputClass' $style $required $readonly $disabled>$value</textarea>
					</div>
				</div>";
    }
	private static function Text($title, $type, $name, $id, $value, $placeholder, $class, $inputClass, $style, $star, $required, $readonly, $disabled){
		$value=!empty($value)?"value='$value'":NULL;
		echo "<div class='$class'>
					<div class='mb-3'>
						<label for='$id' class='form-label'>$title$star</label>
						<input type='$type' name='$name' id='$id' placeholder='$placeholder' $value class='$inputClass' $style $required $readonly $disabled>
					</div>
				</div>";
	}
}