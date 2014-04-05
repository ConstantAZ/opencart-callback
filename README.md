opencart-callback
=================

Opencart 1.5.x ajax callback module

User interaction:  
1. User clicks on the link.  
2. Modal window with a form is shown to the user.  
3. User fills the form fields.  
   If he's logged in, then name and phone fields will be filled from account info.  
   If he's not, he'll have to input captcha (if it's enabled in module settings).  
4. User submits the form.  
5. Modal window with results is shown.  
6. If all is ok, email is sent (either to default store address or one entered in module settings).  
7. UX galore!  

Localisation:  
English and Russian language files included.

Requirements:  
1. Opencart 1.5.x  
2. jQuery.  
2. Colorbox.  
All of the above should be available in your opencart installation by default. If not - it's probably your fault.  
vqmod is optional, but you'll have to modify 1 core file if you don't have it installed (I won't blame you).  
Module templates use some HTML5 attributes, so change them if you wan't to be nonHTML5 compliant.  

Istallation:  
1. Copy folders to your opencart directory.  
2. Go to site backend, enable module and adjust its settings.  
If you're ok with using opencart layout system, do so, then jump to step 5.  
If you have vqmod installed, jump to step 4.  
3. In /catalog/controller/common/header.php (or any other catalog controller) add  
    $this->data['callback_module'] = $this->config->get('callback_status') ? $this->getChild('module/callback', array()) : null;  
   before   
    $this->data['styles'] = $this->document->getStyles();  
4. Modify your /catalog/view/theme/{your_theme}/template/common/header.tpl (or any other catalog template which is used by controller in step 3)  
   Place <?php echo $callback_module; ?> where you want the module link.  
5. You're finished. Go tell you frinds about this immense accomplishment.  
