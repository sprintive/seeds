const config = require("../theme.json");
const kill = require("kill-port");

const port = config.livereloadPort;
kill(port).then(() => {
  if (process.argv[2] != "--silent") {
    console.log(`Process with the port "${port}" has been killed successfully`);
  }
});
