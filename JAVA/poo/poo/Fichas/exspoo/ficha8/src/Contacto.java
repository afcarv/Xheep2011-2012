import java.util.ArrayList;
//tem a info de um contacto

public class Contacto {

	String nome;
	String Datanascimento;
	int idade;
	char Sexo;
	String Profissao;
	
	public Contacto(String nome, String Datanascimento,int idade, char Sexo, String Profissao){
		this.nome=nome;
		this.Datanascimento=Datanascimento;
		this.idade=idade;
		this.Sexo=Sexo;
		this.Profissao=Profissao;
	}
	public String toString(){
		return " "+nome+" "+idade+" anos de idade "+"do sexo "+Sexo+","+Profissao;
	}
}