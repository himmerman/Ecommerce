<?php
		if (isset($addFunction)) {
			echo "<h2>{$addFunction} Page</h2>";

			echo '<a id="add" href="' . base_url() . 'admin/add' . $addFunction . '">+ Add New ' . $addFunction . '</a>';
		}
		if ($result->num_rows() > 0){
			
			if ($table == "product") {
				// $html = "<form action='" . base_url() . "admin/editMultiProduct' method='post'>";
				// $html .= "<p><input type='submit' value='Edit Products'></p>";
				$html = "<table id='adminTable'>";

			} else {
				$html = "<table id='adminTable'>";
			}

			$html .= "<tr>";

			// if ($table == 'product') {
			// 	$html .= "<th>Multi Edit</th>";
			// }

			foreach ($result->list_fields() as $field) {
				if ($field != 'id') {
					$html .= "<th>$field</th>";
				}
				
			}

			if (!$is_sub_table) {
				$html .= "<th>Action</th>";
			}

			$html .= "</tr>";
			$counter = 0;
			foreach ($result->result() as $row) {
				$html .= "<tr>";
				
				$id = $row->id;
				unset($row->id);
				
				// if ($table == 'product') {
				// 	$html .= "<td><input type='checkbox' name='ids[{$counter}]={$id}' value='{$id}'></td>";
				// 	$counter++;
				// }
				

				foreach ($row as $key => $value) {
					
					if ($key != 'Photo' && $key != 'Price per Unit' && $key != 'Order Fulfilled' && $key != 'Sale Price') {
						$html .= "<td>{$value}</td>";
					} elseif ($key == 'Photo') {
						$html .= "<td><img src='{$value}'></td>";
					} elseif ($key == 'Order Fulfilled') {
						if ($value) {
							$html .= "<td>Yes</td>";
						} else {
							$html .= "<td><span class='required'>No</span></td>";
						}
					} else {
						$html .="<td>\${$value}</td>";
					}		
				}
				$function = ucfirst($table);
				if (!$is_sub_table) {
					$html .= "<td><a href='edit{$function}/{$id}'>Edit</a> <a id='formDelete' onclick='confirmDelete(\"{$function}\", {$id})'>Delete</a></td>";	
				}
				
				$html .= "</tr>";
					
			}
			$html .= "</table>";
			if ($table == "product") {
				$html .= "</form>";
			}
			echo $html;

		} else {
			echo "No result";
		}

?>