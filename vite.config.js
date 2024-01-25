import {defineConfig} from 'vite'
import fs from "fs";

// https://vitejs.dev/config
export default defineConfig(({command, mode}) => {
    return {
        root: '',
        base: '/local/build/',
        publicDir: '/sites/main',
        build: {
            outDir: 'local/build/',
            emptyOutDir: true,
            manifest: 'manifest.json',
            rollupOptions: {
                input: [
                    '/resources/styles/main.scss',
                    '/resources/scripts/main.js',
                ],
            },
        },

        server: {
            https: false,
            host: 'localhost',
        },

        plugins: [
            //vue(),
            {
                name: 'php-reload',
                handleHotUpdate({file, server}) {
                    if (file.endsWith('.php')) {
                        server.ws.send({type: 'full-reload', path: '*'})
                    }
                },
            },
            {
                name: "dev-mode",
                apply: "serve",
                configureServer(server) {
                    const flagFile = __dirname + "/local/build/.hot";

                    server.httpServer?.once('listening', () => {
                        const address = server.httpServer?.address()
                        fs.writeFileSync(flagFile, `//${address.address}:${address.port}`);
                    });

                    // Delete the flag file
                    for (const event of ["exit", "SIGINT", "uncaughtException"]) {
                        process.on(event, function (err) {
                            fs.existsSync(flagFile) ? fs.unlinkSync(flagFile) : null;

                            if (event === "uncaughtException") {
                                console.error(err);
                            }

                            process.exit();
                        });
                    }
                }
            }
        ],

        // required for in-browser template compilation
        // https://v3.vuejs.org/guide/installation.html#with-a-bundler
        // resolve: {
        //     alias: {
        //         //vue: 'vue/dist/vue.esm-bundler.js'
        //         '~bootstrap': resolve(__dirname, 'node_modules/bootstrap'),
        //     }
        // }
    }
})
