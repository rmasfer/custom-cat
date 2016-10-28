(function($){
    if ($('#custom-cat-container').length < 1) {
        return;
    }

    var taxonomySaver = {
        template: "#taxonomy-saver-template",
        data: function(){
            return {
                showTaxonomySaver: false,
                searchedText: null
            }
        },
        created: function(){
            var vm = this;
            vm.$parent.$on('cat-selector-no-results', function(searchedText){
                vm.showTaxonomySaver = true;
                vm.searchedText = searchedText;
            });

            //vm.$on('ts-save', vm.save);
        },
        mounted: function(){
            var vm = this;
            //$(vm.$el).find('.button-save').on('click', function(){
            //   vm.$emit('ts-save');
            //});
        },
        methods: {
            save: function(){
                var vm = this;
                $.ajax({
                    url: window.ajaxurl,
                    data: {
                        action: 'insert_term',
                        taxonomy: vm.$parent.taxonomy,
                        term: vm.searchedText
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
            taxonomy: String
        },
        mounted: function(){
            var vm = this;
            //console.log(this.$el);
            var catSelector = $(this.$el).find('.cat-selector');
            catSelector.chosen({
                width: '300px'
            }).change(function(){
                vm.selected = $(this).val();
                vm.$emit('cat-selector-value-change');
            });
            catSelector.on('chosen:no_results', function(event, params){
                var noResultsValue = $('.' + vm.containerClass).find('.search-field input').val();
                vm.$emit('cat-selector-no-results', noResultsValue);
            });

        },
        created: function(){
            var vm = this;
            vm.$on('cat-selector-value-change', vm.save);
            vm.$on('ts-saved', function(newTerm){
                vm.selected.push(newTerm);
            });
        },
        methods: {
            save: function(){
                var vm = this;
                console.log(vm.selected);
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
                    vm.selected = responseObject.currentTerms;
                });
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