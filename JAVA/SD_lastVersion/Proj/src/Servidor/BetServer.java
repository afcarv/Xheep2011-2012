/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package Servidor;

/**
 * * @author jlnabais
 * @author afcarv
 * */
import java.net.*;
import java.util.ArrayList;
import java.io.*;
import RMIServer.*;
import Objects.*;

import java.rmi.RemoteException;

public class BetServer {

	public static void main(String[] args) {
		new BetServer();
	}
        //2 tipos de servidor, se um cair tenta ligar o outro
	public BetServer() {
		Servidor servidorTCP = new Servidor();
                
                
                
//		try {
//			ServerRMI servidorRMI = new ServerRMI();
//		} catch (RemoteException e) {
//			System.out.println(e.getMessage());
//		}
	}

}

