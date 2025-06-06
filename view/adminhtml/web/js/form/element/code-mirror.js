define([
    'jquery',
    './abstract'
], function ($, Abstract) {
    'use strict';

    return Abstract.extend({
        defaults: {
            cols: 15,
            rows: 2,
            elementTmpl: 'Cytracon_UiBuilder/form/element/code',
            mode: 'css',
            editor: ''
        },

        onElementRender: function () {
            this.loadCodeMirror();
        },

        afterLoadData: function () {
            if (this.editor && (typeof this.value()  !== "undefined")) {
                this.editor.setValue(this.value());
            }
        },

        loadCodeMirror: function () {
            var self = this;
            var uid  = this.uid;
            require([
                'jquery',
                'Cytracon_UiBuilder/js/cm/lib/codemirror',
                'Cytracon_UiBuilder/js/cm/mode/css/css',
                'Cytracon_UiBuilder/js/cm/mode/javascript/javascript'
            ], function($, CodeMirror) {
                if ($('#' + uid).length && !self.editor) {
                    var editor = CodeMirror.fromTextArea($('#' + uid)[0], {
                        lineNumbers: true,
                        mode: self.mode,
                        theme: 'default'
                    });
                    editor.on("change", function() {
                        self.value(editor.getValue());
                    });
                    self.editor = editor;
                }
            });
        }
    });
});