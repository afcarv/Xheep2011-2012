package Ficha5_2;
public class Cliente {

	String Nome;
	int n_conta;
	String tipo;
	double saldo;
	
	//contructores, para poder editar atributos de um dado cliente:
	public Cliente(String string, int i, String string2, double d) {
		
		Nome = string;
		n_conta = i;
		tipo = string2;
		saldo = d;
	
	}

	public void levantamento(double valor){
	
		saldo = saldo - valor;
	}
	
	public int getNum_conta(){
		return n_conta;
	}
	
	public double get_saldo(){
		return saldo;
	}

	public void deposito(double valor){
		
		saldo = saldo + valor;	
	}
	
	public void Consulta_de_saldo(){
		System.out.print("O seu saldo é "+saldo);
	}
}