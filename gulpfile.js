const gulp = require('gulp'),
    imagemin = require('gulp-imagemin'),
    babel = require('gulp-babel'),
    uglify = require('gulp-uglify'),
    clean = require('gulp-clean'),
    cleanCSS = require('gulp-clean-css'),
    rename = require('gulp-rename');

gulp.task('watch:js', function () {
    return gulp.watch('resources/assets/js/**/*.js', gulp.series('compilar-js'));
});

gulp.task('watch:descompilado', function () {
    return gulp.watch('resources/assets/js/**/*.js', gulp.series('descompilar-js'));
});

//otimização de css
gulp.task('clean-css', () => {
    return gulp.src('public/css', { allowEmpty: true })
        .pipe(clean());
});

gulp.task('compilar-css', gulp.series('clean-css', function gerarCssMenor(done) {
    gulp.src('resources/assets/css/**/*')
        .pipe(cleanCSS())
        .pipe(gulp.dest('public/css'));

    gulp.src('resources/assets/js/**/*.css')
        .pipe(cleanCSS())
        .pipe(gulp.dest('public/js'));    


    gulp.src('resources/assets/bootstrap-vue/**/*')
        .pipe(cleanCSS())
        .pipe(gulp.dest('public/bootstrap-vue'));

    done();
}));

//otimização de imagens
gulp.task('clean-img', function () {
    return gulp.src('public/images', { allowEmpty: true })
        .pipe(clean());
});

gulp.task('compilar-img', gulp.series('clean-img', function gerarImagemMenor(done) {
    gulp.src('resources/assets/images/**/*')
        .pipe(imagemin())
        .pipe(gulp.dest('public/images'));

    done();
}));

//otimização de javascript
gulp.task('clean-js', function limparJsAntigo() {

    return gulp.src('public/js', { allowEmpty: true })
        .pipe(clean());
});

gulp.task('bibliotecas-compiladas', (done) => {

    /*
     *
     *  https://github.com/google/material-design-icons/releases a pasta iconfont foi retirada daqui deste download
     *  @versão 3.0.1
     */
    gulp.src('resources/assets/iconfont/material-icons.css')
        .pipe(cleanCSS())
        .pipe(gulp.dest('public/iconfont'));

    gulp.src([
        'resources/assets/iconfont/MaterialIcons-Regular.eot',
        'resources/assets/iconfont/MaterialIcons-Regular.ijmap',
        'resources/assets/iconfont/MaterialIcons-Regular.svg',
        'resources/assets/iconfont/MaterialIcons-Regular.ttf',
        'resources/assets/iconfont/MaterialIcons-Regular.woff',
        'resources/assets/iconfont/MaterialIcons-Regular.woff2',
        'resources/assets/iconfont/calibri.ttf',
        'resources/assets/iconfont/calibrib.ttf',
        'resources/assets/iconfont/calibri.ufm',
        'resources/assets/iconfont/calibrib.ufm',
        'resources/assets/iconfont/calibrii.ttf',
        'resources/assets/iconfont/calibrii.ufm',
    ])
        .pipe(gulp.dest('public/iconfont'));

    //copiando jquery
    gulp.src([
        'node_modules/jquery/dist/jquery.min.js',
    ])
        .pipe(gulp.dest('public/js'));

    //copiando datatables
    gulp.src([
        'resources/assets/datatables/datatables.min.css',
        'resources/assets/datatables/datatables.min.js',
        'resources/assets/datatables/pt-br.txt',
    ])
        .pipe(gulp.dest('public/datatables'));

    gulp.src([
        'node_modules/materialize-css/dist/js/materialize.min.js',
        'node_modules/materialize-css/dist/css/materialize.min.css',
    ])
        .pipe(gulp.dest('public/materialize-css'));

    //copiando bootstrap
    gulp.src([
        'node_modules/bootstrap/dist/**/*',
    ])
        .pipe(gulp.dest('public/bootstrap'));

    //bootstrap-native
    gulp.src([
        'node_modules/bootstrap.native/dist/bootstrap-native-v4.min.js',
    ])
        .pipe(gulp.dest('public/bootstrap/js'));

    //vanilla-text-mask
    gulp.src([
        'node_modules/vanilla-text-mask/dist/vanillaTextMask.js',
    ])
        .pipe(gulp.dest('public/js'));

    done();
});


gulp.task('compilar-js', gulp.series('clean-js', 'bibliotecas-compiladas', function transpilarUglify() {

    return gulp.src('resources/assets/js/**/*.js')
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(uglify())
        .pipe(gulp.dest('public/js'));
}));

gulp.task('compilar', gulp.parallel('compilar-img', 'compilar-css', gulp.series('compilar-js', 'bibliotecas-compiladas')));

gulp.task('descompilar-js', gulp.series('bibliotecas-compiladas', (done) => {
    gulp.src('resources/assets/js/**/*.js')
        .pipe(gulp.dest('public/js'));
    done();
}));