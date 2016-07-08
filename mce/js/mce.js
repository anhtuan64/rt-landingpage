/**
 * This file for register button insert shortcode to TinyMCE.
 *
 * @since  1.0
 * @author KingKongThemes
 * @link   http://www.kingkongthemes.com
 */
 
(function() {
	tinymce.create('tinymce.plugins.rt_pre_shortcodes_button', {
		init : function(ed, url) {
			title = 'rt_pre_shortcodes_button';
			tinymce.plugins.rt_pre_shortcodes_button.theurl = url;
			ed.addButton('rt_pre_shortcodes_button', {
				title	:	'Select Shortcode',
				icon	:	'rt_icon',
				type : 'menubutton',
				/* List Button */
				menu: [
					
					/* -----------Home Product----------- */
					{
						text: 'Home Product',
						value: 'Home Product',
						onclick: function() {
							ed.insertContent( '[home_product /]');
						}
					},	// Accordion

					/* -----------Blog----------- */
					{
						text: 'Blog',
						value: 'Blog',
						menu: [
							/* -----------Rt Blog-----------	*/
							{
								text: 'Rt Blog',
								value: 'Rt Blog',
								onclick: function() {
									ed.windowManager.open( {
										title: 'Rt Blog',
										body: [
											{type : 'listbox', name : 'style', label						:	'Style', 'values': [{text: 'Style 1', value: '1'}, {text: 'Style 2', value: '2'}, {text: 'Style 3', value: '3'}, {text: 'Style 4', value: '4'}, {text: 'Style 5', value: '5'}, {text: 'Style 6', value: '6'}, {text: 'Style 7', value: '7'}]},
											{type : 'textbox', name : 'posts_per_page', label				:	'Số lượng bài viết', value : '5'},
											{type : 'textbox', name : 'categories', label					:	'Danh mục (Id / Slug)', value : ''},
											{type : 'textbox', name : 'custom_text', label					:	'Sửa chữ "xem thêm"', value : 'Xem Thêm'},
											{type : 'textbox', name : 'custom_link', label					:	'Link xem thêm', value : ''},
											{type : 'listbox', name : 'hide_category', label				:	'Ẩn danh mục', 'values': [{text: 'Hiện', value: '1'}, {text: 'Ẩn', value: '0'}]},
											{type : 'listbox', name : 'hide_viewmore', label				:	'Ẩn nút xem thêm', 'values': [{text: 'Hiện', value: '1'}, {text: 'Ẩn', value: '0'}]},
										],	
										onsubmit: function(e){
											ed.insertContent( '[rtblog style="'+ e.data.style +'" posts_per_page="'+ e.data.posts_per_page +'" categories="'+ e.data.categories +'" custom_text="'+ e.data.custom_text +'" custom_link="'+ e.data.custom_link +'" hide_category="'+ e.data.hide_category +'" hide_viewmore="'+ e.data.hide_viewmore +'"][/rtblog]');
										}
									});
								}
							},	// Rt Blog

							/* -----------Rt Blog Carousel-----------	*/
							{
								text: 'Rt Blog Carousel',
								value: 'Rt Blog Carousel',
								onclick: function() {
									ed.windowManager.open( {
										title: 'Rt Blog Carousel',
										body: [
											{type : 'textbox', name : 'custom_post_type', label				:	'Custom Post Type', value : 'post'},
											{type : 'textbox', name : 'taxonomy', label						:	'Taxonomy Name', value : ''},
											{type : 'textbox', name : 'category', label						:	'Danh mục (Id / Slug)', value : ''},
											{type : 'listbox', name : 'style', label						:	'Style', 'values': [{text: 'Blog Template 1', value: 'blog-1'}, {text: 'Blog Template 2', value: 'blog-2'}]},
											{type : 'textbox', name : 'posts_per_page', label				:	'Số lượng bài viết', value : '5'},
											{type : 'listbox', name : 'slide_type', label					:	'Chiều của Carousel', 'values': [{text: 'Ngang', value: 'horizontal'}, {text: 'Dọc', value: 'vertical'}]},
											{type : 'textbox', name : 'posts_per_slide', label				:	'Số lượng bài viết / slide', value : '1'},
											{type : 'listbox', name : 'autoplay', label						:	'Tự động chạy?', 'values': [{text: 'Tự động', value: 'true'}, {text: 'Không tự động', value: 'false'}]},
											{type : 'textbox', name : 'margin', label						:	'Khoảng cách giữa 2 phần tử', value : '0'},
											{type : 'textbox', name : 'width', label						:	'Width của 1 phần tử', value : '300'},
											{type : 'textbox', name : 'height', label						:	'Height của 1 phần tử', value : '250'},
											{type : 'listbox', name : 'hide_category', label				:	'Ẩn danh mục', 'values': [{text: 'Hiện', value: '1'}, {text: 'Ẩn', value: '0'}]},
											{type : 'listbox', name : 'hide_description', label				:	'Ẩn mô tả', 'values': [{text: 'Hiện', value: '1'}, {text: 'Ẩn', value: '0'}]},
										],	
										onsubmit: function(e){
											ed.insertContent( '[rtblog_carousel custom_post_type="'+ e.data.custom_post_type +'" taxonomy="'+ e.data.taxonomy +'" category="'+ e.data.category +'" style="'+ e.data.style +'" posts_per_page="'+ e.data.posts_per_page +'" slide_type="'+ e.data.slide_type +'" posts_per_slide="'+ e.data.posts_per_slide +'" autoplay="'+ e.data.autoplay +'" margin="'+ e.data.margin +'" width="'+ e.data.width +'" height="'+ e.data.height +'" hide_category="'+ e.data.hide_category +'" hide_description="'+ e.data.hide_description +'"][/rtblog_carousel]');
										}
									});
								}
							},	// Rt Blog Carousel
						], // Blog
					},	// Blog
					
					
				],
			});

		},
		createControl : function(n, cm) {
			return null;
		}
	});

	tinymce.PluginManager.add('rt_pre_shortcodes_button', tinymce.plugins.rt_pre_shortcodes_button);

})();