package Servidor;
/**
 * [SD]Bet-and-Win v1
 * @author afcarv
 * @author jlnabais
 */
import java.io.*;

public class FicheiroDeObjectos {

	private ObjectInputStream iS;
	private ObjectOutputStream oS;

	public void abreLeitura(String nomeDoFicheiro) throws IOException {
		iS = new ObjectInputStream(new FileInputStream(nomeDoFicheiro));
	}
	
	//Recebe o nome do ficheiro
	public void abreEscrita(String nomeDoFicheiro) throws IOException{
		oS = new ObjectOutputStream(new
		FileOutputStream(nomeDoFicheiro));
	}
	
	//Devolve o objecto lido
	public Object leObjecto() throws IOException, ClassNotFoundException{
		return iS.readObject();
	}
	
	//M�todo para escrever um objecto no ficheiro
	//Recebe o objecto a escrever
	public void escreveObjecto(Object o) throws IOException{
		oS.writeObject(o);
	}

	//M�todo para fechar um ficheiro aberto em modo leitura
	public void fechaLeitura() throws IOException{
		iS.close();
	}
	//M�todo para fechar um ficheiro aberto em modo escrita
	public void fechaEscrita() throws IOException{
		oS.close();
	}

	

}
