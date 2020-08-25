use std::io::{Error};
// use std::net::{Ipv4Addr, SocketAddrV4, TcpListener};

pub fn get_random_port() -> Result<u16, Error> {
  // let loopback = Ipv4Addr::new(127, 0, 0, 1);
  // let socket = SocketAddrV4::new(loopback, 0);
  // let listener = TcpListener::bind(socket)?;
  // Ok(listener.local_addr().unwrap().port())
  Ok(4444)
}
