<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Auto Acronym
 * 
 * This file must be placed in the
 * system/plugins/ folder in your ExpressionEngine installation.
 *
 * @package AutoAcronym
 * @version 1.0
 * @author Erik Reagan http://erikreagan.com
 * @copyright Copyright (c) 2009 Erik Reagan
 * @see http://erikreagan.com/projects/auto_acronym/
 */

$plugin_info       = array(
   'pi_name'        => 'Auto Acronym',
   'pi_version'     => '1.0',
   'pi_author'      => 'Erik Reagan',
   'pi_author_url'  => 'http://erikreagan.com',
   'pi_description' => 'Automatically wraps certain acronyms in the HTML &lt;acronym&gt; tag. Written for net.tutsplus.com',
   'pi_usage'       => Auto_acronym::usage()
   );

class Auto_acronym
{

   var $return_data  = "";

   function Auto_acronym()
   {
      // We need the template class to help us with the plugin
      $this->EE =& get_instance();

      echo "<pre>";
      print_r($this->EE);
      echo "</pre>";
      exit;
      

      // First we grab the data we are working with. It's either a value within the tag or the text between the open & close tag
      $data = ($this->EE->TMPL->fetch_param('data')) ? $this->EE->TMPL->fetch_param('data') : $this->EE->TMPL->tagdata ;
      
      
      // Now we will setup our array of acronyms to match against
      $acronyms = array(
         'HTML' => 'HyperText Markup Language',
         'CSS' => 'Cascading Style Sheets',
         'RSS' => 'Really Simple Syndication'
         );
      
      // Loop through the acronyms
      foreach ($acronyms as $short => $long)
      {
         // We will run a string replacement but only if the needle is in our haystack.
         // We want as little processing as possible so we always check to make sure
         // our needle is contained in the haystack
         if (strpos($data, $short) !== FALSE)
         {
            // Now that we know the needle is in the haystand we will wrap it with the acronym tag and assign its title
            $data = str_replace($short, '<acronym title="'.$long.'">'.$short.'</acronym>', $data);
         }         
      }
      
      
      // This returns the plugin data back to the ExpressionEngine template
      $this->return_data = $data;

   }

   /**
    * Plugin Usage
    */

   // This function describes how the plugin is used.
   //  Make sure and use output buffering

   function usage()
   {
      ob_start(); 
?>

Notice
===========================
This plugin was written for a tutorial on net.tutsplus.com. It is not meant to be a plugin used on sites as it only has a minimal dictionary of acronyms. You can, however, add your own in and use it as you wish.



The "dictionary" of acronyms is stored in an array within the plugins/pi.auto_acronym.php file.

Automatically turn a string into an HTML acronym if it is within our acronym dictionary. You can do this with individual words or large blocks of text.


Simple Example
===========================

{exp:auto_acronym data="HTML"}

This outputs:
<acronym title="Hypertext Markup Language">HTML</acronym> in your ExpressionEngine template.



Large Block Example
===========================

{exp:auto_acronym}

<p>My name is Erik and I am an addict. I stay up late into the night marking up HTML and CSS with magical alignment.
Whitespace speaks volumes of my care and finesse of the code. My RSS subscribers wait on their toes for my next
example of code beauty. Okay...not really.</p>

{/exp:auto_acronym}

This outputs:
<p>My name is Erik and I am an addict. I stay up late into the night marking up <acronym title="Hypertext Markup Language">HTML</acronym> and <acronym title="Cascading Style Sheets">CSS</acronym> with magical alignment.
Whitespace speaks volumes of my care and finesse of the code. My <acronym title="Really Simple Syndication">RSS</acronym> subscribers wait on their toes for my next
example of code beauty. Okay...not really.</p>
<?php
      $buffer         = ob_get_contents();

      ob_end_clean(); 

      return $buffer;
   }
   // END

}


/* End of file pi.auto_acronym.php */
/* Location: ./system/plugins/pi.er_auto_acronym.php */