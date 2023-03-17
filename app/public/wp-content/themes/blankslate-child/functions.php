<?php
add_action("wp_enqueue_scripts", "wp_child_theme");
function wp_child_theme() 
{
	if((esc_attr(get_option("wp_child_theme_setting")) != "Yes")) 
	{
		wp_enqueue_style("parent-stylesheet", get_template_directory_uri()."/style.css");
	}

	wp_enqueue_style("child-stylesheet", get_stylesheet_uri());
	wp_enqueue_script("child-scripts", get_stylesheet_directory_uri() . "/js/scripts.js", array("jquery"), "6.1.1", true);
}

if(!function_exists("uibverification"))
{
	function uibverification() 
	{
        if((esc_attr(get_option("wp_child_theme_setting_html")) != "Yes")) 
        {
            if((is_home()) || (is_front_page())) 
            {
            ?><meta name="uib-verification" content="5C3A329C694103F70F0141F224D16049"><?php
            }
        }
	}
}
add_action("wp_head", "uibverification", 1);

function wp_child_theme_register_settings() 
{ 
	register_setting("wp_child_theme_options_page", "wp_child_theme_setting", "wct_callback");
    register_setting("wp_child_theme_options_page", "wp_child_theme_setting_html", "wct_callback");
}
add_action("admin_init", "wp_child_theme_register_settings");

function wp_child_theme_register_options_page() 
{
	add_options_page("Child Theme Settings", "Child Theme", "manage_options", "wp_child_theme", "wp_child_theme_register_options_page_form");
}
add_action("admin_menu", "wp_child_theme_register_options_page");

function wp_child_theme_register_options_page_form()
{ 
?>
<div id="wp_child_theme">
	<h1>Child Theme Options</h1>
	<h2>Include or Exclude Parent Theme Stylesheet</h2>
	<form method="post" action="options.php">
		<?php settings_fields("wp_child_theme_options_page"); ?>
		<p><label><input size="3" type="checkbox" name="wp_child_theme_setting" id="wp_child_theme_setting" <?php if((esc_attr(get_option("wp_child_theme_setting")) == "Yes")) { echo " checked "; } ?> value="Yes"> Tick to disable the parent stylesheet<label></p>
        <p><label><input size="3" type="checkbox" name="wp_child_theme_setting_html" id="wp_child_theme_setting_html" <?php if((esc_attr(get_option("wp_child_theme_setting_html")) == "Yes")) { echo " checked "; } ?> value="Yes"> Tick to disable the <a href="https://uibmeta.org">UIB Meta Tag</a> on your website homepage<label></p>
		<?php submit_button(); ?>
	</form>
</div>
<?php
}

/* Moi */

/*Logo*/
add_theme_support( 'custom-logo' );

/*Menu*/
register_nav_menus( array( 'menu-footer' => 'Menu footer') );

/*
* On utilise une fonction pour créer notre custom post type 'Les goûts'
*/

function wpm_custom_post_type() {

	// On rentre les différentes dénominations de notre custom post type qui seront affichées dans l'administration
	$labels = array(
		// Le nom au pluriel
		'name'                => _x( 'Les goûts', 'Post Type General Name'),
		// Le nom au singulier
		'singular_name'       => _x( 'Les goûts', 'Post Type Singular Name'),
		// Le libellé affiché dans le menu
		'menu_name'           => __( 'Les goûts'),
		// Les différents libellés de l'administration
		'all_items'           => __( 'Tous les goûts'),
		'view_item'           => __( 'Voir les goûts'),
		'add_new_item'        => __( 'Ajouter un nouveau goût'),
		'add_new'             => __( 'Ajouter'),
		'edit_item'           => __( 'Editer le goût'),
		'update_item'         => __( 'Modifier le goût'),
		'search_items'        => __( 'Rechercher un goût'),
		'not_found'           => __( 'Non trouvé'),
		'not_found_in_trash'  => __( 'Non trouvé dans la corbeille'),
	);
	
	// On peut définir ici d'autres options pour notre custom post type
	
	$args = array(
		'label'				=> __( 'Les goûts'),
		'description'		=> __( 'Les goûts de Planty'),
		'labels'			=> $labels,
		'menu_icon'			=> 'dashicons-carrot',
		// On définit les options disponibles dans l'éditeur de notre custom post type ( un titre, un auteur...)
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
		/* 
		* Différentes options supplémentaires
		*/
		'show_in_rest' => true,
		'hierarchical'        => false,
		'public'              => true,
		'has_archive'         => true,
		'rewrite'			  => array( 'slug' => 'les-gouts'),

	);
	
	// On enregistre notre custom post type qu'on nomme ici "serietv" et ses arguments
	register_post_type( 'lesgouts', $args );

}

add_action( 'init', 'wpm_custom_post_type', 0 );


add_action( 'init', 'wpm_add_taxonomies', 0 );

//On crée 1 taxonomie personnalisée: Goût

function wpm_add_taxonomies() {
	
	// Taxonomie Goût

	// On déclare ici les différentes dénominations de notre taxonomie qui seront affichées et utilisées dans l'administration de WordPress
	$labels_gout = array(
		'name'              			=> _x( 'Goût', 'taxonomy general name'),
		'singular_name'     			=> _x( 'Goût', 'taxonomy singular name'),
		'search_items'      			=> __( 'Chercher un goût'),
		'all_items'        				=> __( 'Tous les goûts'),
		'edit_item'         			=> __( 'Editer le goût'),
		'update_item'       			=> __( 'Mettre à jour le goût'),
		'add_new_item'     				=> __( 'Ajouter un nouveau goût'),
		'new_item_name'     			=> __( 'Valeur du nouveau goût'),
		'separate_items_with_commas'	=> __( 'Séparer les goûts avec une virgule'),
		'menu_name'         => __( 'Goût'),
	);

	$args_gout = array(
	// Si 'hierarchical' est défini à false, notre taxonomie se comportera comme une étiquette standard
		'hierarchical'      => false,
		'labels'            => $labels_gout,
		'show_ui'           => true,
		'show_in_rest' 		=> true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'gout' ),
	);

	register_taxonomy( 'gout', 'lesgouts', $args_gout );
}