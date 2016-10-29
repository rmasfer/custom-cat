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
        <span class="title">{{ title }}</span>
        <select class="cat-selector" multiple data-placeholder="Select Category" v-model="selected">
            <option v-for="category in termsList" v-bind:value="category.value">{{ category.name }}</option>
        </select>
        Value {{ selected }}
        <taxonomy-saver></taxonomy-saver>
    </div>
</script>
<script type="text/x-template" id="taxonomy-saver-template">
    <div class="taxonomy-save-container" v-show="showTaxonomySaver">
        <input type="text" name="input_new_taxonomy" v-bind:value="searchedText"/>
        <button class="button-save" @click.prevent="save">Save</button>
    </div>
</script>
