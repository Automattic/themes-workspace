'use strict';

const sass = require('node-sass');
const fs = require('fs');

const outFile = './output.css';

sass.render({
		file: './sass/main.scss',
		// data: 'body{background:blue; a{color:black;}}',
		outputStyle: 'expanded',
		outFile,
		sourceMap: true, // or an absolute or relative (to outFile) path
	}, (error, result) => { // node-style callback from v3.0.0 onwards
		if(!error){
			// No errors during the compilation, write this result on the disk
			fs.writeFile(outFile, result.css, function(err){
				if(err){
					//file written on disk
					throw err;
				}
		});
	}
});
