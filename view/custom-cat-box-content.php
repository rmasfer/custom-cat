<div class="custom-cat-container" id="custom-cat-container">
    <?php
    foreach ($available_taxonomies as $taxonomy_name => $available_taxonomy) {
    ?>
    <custom-selector
        v-bind:post-id="<?php echo $post_id;?>"
        v-bind:current-terms="<?php echo str_replace('"', '\'', json_encode($available_taxonomy['current_terms_list']));?>"
        v-bind:terms-list="<?php echo str_replace('"', '\'', json_encode($available_taxonomy['available_terms_list']));?>"
        taxonomy="<?php echo $taxonomy_name; ?>"
        title="<?php echo $taxonomy_name; ?>"
    >
    </custom-selector>
    <?php
    }
    ?>
</div>


<script type="text/x-template" id="custom-container-template">
    <div class="custom-selector-component-container" v-bind:class="containerClass">
        <div class="title">{{ title }}</div>
        <select class="cat-selector" multiple data-placeholder="Select Category" v-model="selected">
            <option v-for="category in termsList" v-bind:value="category.value">{{ category.name }}</option>
        </select>
<!--        Value {{ selected }}-->
        <taxonomy-saver></taxonomy-saver>
    </div>
</script>
<script type="text/x-template" id="taxonomy-saver-template">
    <div class="taxonomy-save-container" v-show="showTaxonomySaver">
	    <div class="bold">Insert new term</div>
	    <div class="form-wrap">
            <div v-show="formHasError">Have some errors</div>
	        <div class="element-container form-field">
		        <label for="input_new_taxonomy">Name</label>
	            <input type="text"
                       name="input_new_taxonomy"
                       v-model="searchedText"
                       v-bind:class="{'has-error' : searchedTextHasError}"
                />
		        <p>The name is how it appears on your site.</p>
	        </div>
		    <div class="element-container form-field">
		        <label for="input_new_slug">Slug</label>
	            <input type="text"
                       name="input_new_slug"
                       v-model="slug"
                       v-bind:class="{'has-error' : slugHasError}"
                />
			    <p>The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</p>
		    </div>
	        <button class="button button-save" @click.prevent="save">Save</button>
	    </div>
    </div>
</script>
