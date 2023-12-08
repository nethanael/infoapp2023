import ActiveDirectory from "activedirectory2";
 
// Configurar los parámetros de conexión con Active Directory
const adConfig = {
  url: 'ldap://icetel.ice:3268',
  baseDN: 'dc=icetel,dc=ice',
};
 
// Función para autenticar al usuario con Active Directory
export const authenticateUser = (req, res) => {
  const { username, password } = req.body;
 
  const ad = new ActiveDirectory(adConfig);
  ad.authenticate(username+"@icetel.ice", password, (err, auth) => {
    if (err) {
      return res.status(500).json({ success: false, message: 'Error al autenticar el usuario' });
    }
    if (auth) {
      console.log('Autenticación exitosa');
      return res.status(200).json({ success: true, message: 'Autenticación exitosa' });
    } else {
      return res.status(401).json({ success: false, message: 'Credenciales inválidas' });
    }
  });
};