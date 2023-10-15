<template>
    <div class="card">
        <div class="card-header border-bottom-0 pb-0">
            <ul class="nav nav-tabs border-bottom-0" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="write-tab" data-bs-toggle="tab" :data-bs-target="tabId('write', '#')" type="button" role="tab" aria-controls="write-tab-pane" aria-selected="true">Write</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="preview-tab" data-bs-toggle="tab" :data-bs-target="tabId('preview', '#')" type="button" role="tab" aria-controls="preview-tab-pane" aria-selected="false">Preview</button>
                </li>
            </ul>
        </div>
        <div class="card-body tab-content" id="myTabContent">
            <div class="tab-pane fade show active" :id="tabId('write')" role="tabpanel" aria-labelledby="write-tab" tabindex="0">
                <slot></slot>
            </div>
            <div class="tab-pane fade" v-html="preview" :id="tabId('preview')" role="tabpanel" aria-labelledby="preview-tab" tabindex="0">

            </div>
        </div>
    </div>
</template>

<script>
import MarkdownIt from 'markdown-it';
import prism from 'markdown-it-prism';
import autosize from 'autosize';

const md = new MarkdownIt();
md.use(prism);

export default {
    name: "MEditor",
    props: ['body', 'name'],

    computed: {
        preview () {
            return md.render(this.body)
        }
    },

    methods: {
        tabId(tabName, hash = "") {
            return `${hash}${tabName}${this.name}`;
        }
    },

    updated () {
        //autosize(document.querySelector('textarea')); javasceipt syntax or
        autosize(this.$el.querySelector('textarea')); //Vue syntax
    }

}
</script>

