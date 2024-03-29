﻿/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.plugins.setLang('a11yhelp','el',{
    accessibilityHelp:{
        title:'Οδηγίες Προσβασιμότητας',
        contents:'Περιεχόμενα Βοήθειας. Πατήστε ESC για κλείσιμο.',
        legend:[{
            name:'Γενικά',
            items:[{
                name:'Εργαλειοθήκη Επεξεργαστή',
                legend:'Πατήστε ${toolbarFocus} για να περιηγηθείτε στην γραμμή εργαλείων. Μετακινηθείτε ανάμεσα στις ομάδες της γραμμής εργαλείων με TAB και Shift-TAB. Μετακινηθείτε ανάμεσα στα κουμπία εργαλείων με ΔΕΞΙ και ΑΡΙΣΤΕΡΟ ΒΕΛΑΚΙ. Πατήστε ΚΕΝΟ ή ENTER για να ενεργοποιήσετε το ενεργό κουμπί εργαλείου.'
            },{
                name:'Παράθυρο Διαλόγου Επεξεργαστή',
                legend:'Inside a dialog, press TAB to navigate to next dialog field, press SHIFT + TAB to move to previous field, press ENTER to submit dialog, press ESC to cancel dialog. For dialogs that have multiple tab pages, press ALT + F10 to navigate to tab-list. Then move to next tab with TAB OR RIGTH ARROW. Move to previous tab with SHIFT + TAB or LEFT ARROW. Press SPACE or ENTER to select the tab page.'
            },{
                name:'Editor Context Menu',
                legend:'Press ${contextMenu} or APPLICATION KEY to open context-menu. Then move to next menu option with TAB or DOWN ARROW. Move to previous option with SHIFT+TAB or UP ARROW. Press SPACE or ENTER to select the menu option. Open sub-menu of current option with SPACE or ENTER or RIGHT ARROW. Go back to parent menu item with ESC or LEFT ARROW. Close context menu with ESC.'
            },{
                name:'Editor List Box',
                legend:'Inside a list-box, move to next list item with TAB OR DOWN ARROW. Move to previous list item with SHIFT + TAB or UP ARROW. Press SPACE or ENTER to select the list option. Press ESC to close the list-box.'
            },{
                name:'Editor Element Path Bar',
                legend:'Press ${elementsPathFocus} to navigate to the elements path bar. Move to next element button with TAB or RIGHT ARROW. Move to previous button with  SHIFT+TAB or LEFT ARROW. Press SPACE or ENTER to select the element in editor.'
            }]
        },{
            name:'Εντολές',
            items:[{
                name:' Εντολή αναίρεσης',
                legend:'Πατήστε ${undo}'
            },{
                name:' Εντολή επανάληψης',
                legend:'Πατήστε ${redo}'
            },{
                name:' Εντολή έντονης γραφής',
                legend:'Πατήστε ${bold}'
            },{
                name:' Εντολή πλάγιας γραφής',
                legend:'Πατήστε ${italic}'
            },{
                name:' Εντολή υπογράμμισης',
                legend:'Πατήστε ${underline}'
            },{
                name:' Εντολή συνδέσμου',
                legend:'Πατήστε ${link}'
            },{
                name:' Εντολή Σύμπτηξης Εργαλειοθήκης',
                legend:'Πατήστε ${toolbarCollapse}'
            },{
                name:' Βοήθεια Προσβασιμότητας',
                legend:'Πατήστε ${a11yHelp}'
            }]
        }]
    }
});
