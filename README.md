# Cerebro Backend

Cerebro is a capstone project, in which our team developed a server based password manager, which communicates with a Java desktop client that allows to log into websited with credentials automatically filled in. The server was hosted on a GCP cloud processing platform. The server logic contains of PHP controllers that communicate with a MySQL database. The PHPSecLib library was also used for RSA singature verification/signing.

Since this app requires a high level of security, each request must contain a RSA token (singature) that is based on the incoming request parameters. In an ideal build, each client would have its own unique private key, but for simplicity of the project we decided that each client will have an idential private public key pair. It is also important to note that all the sensitive data is symmetrically encrypted or hashed on the client side.

The documentation for this project can be found in the main branch of the repository
