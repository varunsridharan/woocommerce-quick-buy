module.exports = {
	files: {
		'src/scss/admin.scss': {
			dist: 'assets/css/',
			combine_files: true,
			scss: true,
			autoprefixer: true,
			minify: true,
			watch: true,
		},
		'src/js/admin-script.js': {
			dist: 'assets/js/',
			combine_files: true,
			bable: true,
			watch: true,
		},
		'src/js/frontend-script.js': {
			dist: 'assets/js/',
			combine_files: true,
			bable: true,
			watch: true,
		},
		'src/scss/button-presets.scss': {
			dist: 'assets/css/',
			combine_files: true,
			scss: true,
			autoprefixer: true,
			minify: true,
			watch: true,
		}
	}
};
