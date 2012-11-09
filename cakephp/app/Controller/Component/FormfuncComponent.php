<?php
	App::uses('Component', 'Controller');
	class FormfuncComponent extends Component {
		public function convert_options($result, $model, $key=id, $label='name') {
			$rt = array();
			foreach($result as $item) {
				$rt[$item[$model][$key]] = $item[$model][$label];
			}
			return $rt;
		}
	}
?>