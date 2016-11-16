<div class="custom-cat-container" id="custom-cat-container">
    <?php
    foreach ($available_taxonomies as $taxonomy_name => $available_taxonomy) {
    ?>
    <custom-selector
        v-bind:post-id="<?php echo $post_id;?>"
        v-bind:current-terms="<?php echo (new cc_vue_serializer($available_taxonomy['current_terms_list']));?>"
        v-bind:terms-list="<?php echo (new cc_vue_serializer($available_taxonomy['available_terms_list']));?>"
        v-bind:allow-one="<?php echo $available_taxonomy['allow_one']; ?>"
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
        <select class="cat-selector" multiple data-placeholder="Select one" v-model="selected">
            <option v-for="category in termsList" v-bind:value="category.value">{{ category.name }}</option>
        </select>
        <div class="message message-warning" v-show="allowOne">Only one term allowed</div>
        <taxonomy-saver></taxonomy-saver>
    </div>
</script>
<script type="text/x-template" id="taxonomy-saver-template">
    <div class="taxonomy-save-container" v-show="showTaxonomySaver">
	    <div class="bold"> <?php _e('Insert new term', CC_TEXT_DOMAIN);?> </div>
	    <div class="form-wrap">
            <div v-show="formHasError"> <?php _e('Have some errors', CC_TEXT_DOMAIN);?> </div>
	        <div class="element-container form-field">
		        <label for="input_new_taxonomy"> <?php _e('Name', CC_TEXT_DOMAIN);?> </label>
	            <input type="text"
                       name="input_new_taxonomy"
                       v-model="searchedText"
                       v-bind:class="{'has-error' : searchedTextHasError}"
                />
		        <p> <?php _e('The name is how it appears on your site.', CC_TEXT_DOMAIN); ?> </p>
	        </div>
		    <div class="element-container form-field">
		        <label for="input_new_slug"> <?php _e('Slug', CC_TEXT_DOMAIN); ?> </label>
	            <input type="text"
                       name="input_new_slug"
                       v-model="slug"
                       v-bind:class="{'has-error' : slugHasError}"
                />
			    <p> <?php _e('The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.', CC_TEXT_DOMAIN); ?> </p>
		    </div>
	        <button class="button button-save" @click.prevent="save"> <?php _e('Save', CC_TEXT_DOMAIN); ?> </button>
	    </div>
    </div>
</script>
