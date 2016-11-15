(function($){
    if ($('#custom-cat-container').length < 1) {
        return;
    }

    var taxonomySaver = {
        template: "#taxonomy-saver-template",
        data: function(){
            return {
                showTaxonomySaver: false,
                searchedText: null,
                slug: null,
                formHasError: false
            }
        },
        computed: {
            searchedTextHasError: function(){
                var vm = this;
                return vm.searchedText == "";
            },
            slugHasError: function(){
                var vm = this;
                return vm.slug == "";
            }
        },
        watch: {
            searchedText: function() {
                this.formHasError = false;
            },
            slug: function() {
                this.formHasError = false;
            }
        },
        created: function(){
            var vm = this;
            vm.$parent.$on('cat-selector-no-results', function(searchedText){
                vm.showTaxonomySaver = true;
                vm.searchedText = searchedText;
                vm.slug = searchedText;
            });
            vm.$parent.$on('cat-selector-hide', function(){
                vm.formHasError = false;
                vm.showTaxonomySaver = false;
            });

        },
        mounted: function(){

        },
        methods: {
            save: function(){
                var vm = this;

                if (!vm.validate()) {
                    vm.formHasError = true;
                    return;
                }

                $.ajax({
                    url: window.ajaxurl,
                    data: {
                        action: 'insert_term',
                        taxonomy: vm.$parent.taxonomy,
                        term: vm.searchedText,
                        slug: vm.slug
                    },
                    type: 'POST'
                }).done(function(response){
                    var responseObject = JSON.parse(response);
                    if (!responseObject.status) {
                        return;
                    }
                    vm.$parent.$emit('ts-saved', vm.searchedText);
                    vm.showTaxonomySaver = false;
                });
            },
            validate: function(){
                var vm = this;
                var valid = true;

                if (vm.searchedText == "" || vm.slug == "") {
                    valid = false;
                }

                return valid;
            }
        }
    };

    Vue.component('custom-selector', {
        template:  '#custom-container-template',
        data: function () {
            return {
                selected: this.currentTerms
            }
        },
        props: {
            //selected: [],
            postId: Number,
            currentTerms: Array,
            termsList: Array,
            title: String,
            taxonomy: String,
            allowOne: Boolean
        },
        mounted: function(){
            var vm = this;
            var catSelector = $(this.$el).find('.cat-selector');
            var maximumSelectableOption = 1000;
            if (vm.allowOne) {
                maximumSelectableOption = 1;
            }
            catSelector.chosen({
                width: '95%',
                max_selected_options: maximumSelectableOption
            }).change(function(event, params){
                var inputValues = [];
                if ($(event.currentTarget).val()) {
                    inputValues = $(event.currentTarget).val();
                }
                vm.selected = inputValues;
                vm.$emit('cat-selector-value-change');
            }.bind(this));
            catSelector.on('chosen:no_results', function(event, params){
                var noResultsValue = $('.' + vm.containerClass).find('.search-field input').val();
                if (noResultsValue.length == 1) {
                    vm.$emit('cat-selector-hide');
                    return;
                }
                vm.$emit('cat-selector-no-results', noResultsValue);
            });

        },
        created: function(){
            var vm = this;
            vm.$on('cat-selector-value-change', vm.save);
            vm.$on('ts-saved', function(newTerm){
                vm.termsList.push({name: newTerm, value: newTerm});
                vm.selected.push(newTerm);
                vm.$emit('cat-selector-value-change');
            });
        },
        watch: {

        },
        destroyed: function () {
        },
        updated: function () {
            $(this.$el).find('.cat-selector').trigger('chosen:updated');
        },
        methods: {
            save: function(){
                var vm = this;
                $.ajax({
                    url: window.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'save_category',
                        postId: vm.postId,
                        categoriesToSave: vm.selected,
                        taxonomy: vm.taxonomy
                    }
                })
                .done(function(response){
                    var responseObject = JSON.parse(response);
                    if (!responseObject.status) {
                        return;
                    }
                    if (responseObject.currentTerms == "" || responseObject.currentTerms == null) {
                        return;
                    }
                    vm.selected = responseObject.currentTerms;
                });
            },
            test: function () {
            }
        },
        computed: {
            containerClass: function(){
                return 'container-for-' + this.taxonomy;
            }
        },
        components: {
            'taxonomy-saver': taxonomySaver
        }
    });


    var app = new Vue({
        el: '#custom-cat-container',
        data: {

        },
        mounted: function(){
        }
    });
})(jQuery);