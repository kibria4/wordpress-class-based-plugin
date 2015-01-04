<?php global $post_id; ?>
<table>
	<tr valign="top">
		<th class="metabox_label_column">
			<label for="page">Pages to display on: (All quotes will be displayed on the home page)</label>
		</th>
	</tr>
	<?php
		$pages = get_pages();

		$get_selected = get_post_meta($post_id, 'page', false);
		
		foreach($pages as $page):
			$checked = false;
			$id = (string)$page->ID;
			if(in_array($id, $get_selected[0])){
				$checked = true;
			}
	?>
	<tr>
		<td>

			<label for="<?php echo $page->post_title; ?>"><?php echo $page->post_title; ?></label><input type="checkbox" name="page[]" value="<?php echo $page->ID; ?>" <?php if($checked){ echo "checked"; }; ?>>
		</td>
	</tr>
	<?php endforeach; ?>
</table>