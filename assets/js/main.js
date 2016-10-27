(function($){
    if ($('#custom-cat-container').length < 1) {
        return;
    }

    var taxonomySaver = {
        template: "#taxonomy-saver-template",
        data: function(){
            return {
                showTaxonomySaver: false
            }
        },
        created: function(){
            var vm = this;
            vm.$parent.$on('cat-selector-no-results', function(){
                console.log('event listening');
                vm.showTaxonomySaver = true;
            });
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
            var self = this;
            self.$on('cat-selector-value-change', self.save);
            //self.$on('cat-selector-no-results', function(searchedValue){
            //});
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