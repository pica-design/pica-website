#Project Settings
environment = :production
project_type = :stand_alone
preferred_syntax = :scss
output_style = :expanded  #:nested, :expanded, :compact, or :compressed.
line_comments = true

#Asset Paths
sass_dir = "sass"
css_dir = "stylesheets"

if environment == :development 
	output_style = :expanded  #:nested, :expanded, :compact, or :compressed.
	http_images_path = "//dev.pica.is/pica/wp-content/themes/pica/images/"
	http_generated_images_path = "//dev.pica.is/pica/wp-content/themes/pica/images/"
	generated_images_path = "/Other Pica Shares/Websites/pica/wp-content/themes/pica/images/"
	http_fonts_path = "//dev.pica.is/pica/wp-content/themes/pica/fonts/"
	sprite_load_path = "/Other Pica Shares/Websites/pica/wp-content/themes/pica/images/"
end
if environment == :production 
	output_style = :compressed  #:nested, :expanded, :compact, or :compressed.
	http_images_path = "//images.pica.is/wp-content/themes/pica/images/"
	http_generated_images_path = "//images.pica.is/wp-content/themes/pica/images/"
	generated_images_path = "/Other Pica Shares/Websites/pica/wp-content/themes/pica/images/"
	http_fonts_path = "//fonts.pica.is/wp-content/themes/pica/fonts/"
	sprite_load_path = "/Other Pica Shares/Websites/pica/wp-content/themes/pica/images/"
end