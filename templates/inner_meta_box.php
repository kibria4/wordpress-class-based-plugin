<?php
	global $post;
?>
<table>
	<tr valign="top">
		<th class="metabox_label_column">
			<label for="price">Product Price: </label>
		</th>
		<td>
			<input type="text" name="price" id="price" value="<?php echo get_post_meta( $post->ID, 'price', true ); ?>" />
		</td>
	</tr>
</table>