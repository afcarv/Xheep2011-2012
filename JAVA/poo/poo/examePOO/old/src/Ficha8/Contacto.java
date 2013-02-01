package Ficha8;

import java.util.Date;
import java.util.Calendar;

public class Contacto {
	public String nome;
	//date já que desta forma facilmente se faz a conversão de string para date e vice versa
	public Date aniversario;
	public String sexo;
	public String profissão;
	public String telefone;
	public String email;

	public Contacto()
	{
		nome = "";
		//inicialização:
		aniversario = null;
		sexo = "";
		profissão = "";
		telefone = "";
		email = "";
	}

	Contacto(String _nome, Date _aniversario, String _sexo, String _profissão, String _telefone, String _email)
	{
		this();

		nome = _nome;
		aniversario = _aniversario;
		sexo = _sexo;
		profissão = _profissão;
		telefone = _telefone;
		email = _email;
	}


	public int idade()
	{
		/* http://www.exampledepot.com/egs/java.util/GetAge.html
			class calendar que devolve a data actual
		 */
		Calendar today = Calendar.getInstance();
		Calendar bday = Calendar.getInstance();

		//data do contacto
		bday.setTime(aniversario);

		//cálculo da idade:
		int age = today.get(Calendar.YEAR) - bday.get(Calendar.YEAR);

		//para o caso de fazer anos após a data actual
		if((bday.get(Calendar.MONTH) > today.get(Calendar.MONTH)) || (bday.get(Calendar.MONTH) == today.get(Calendar.MONTH) && 
				bday.get(Calendar.DAY_OF_MONTH) > today.get(Calendar.DAY_OF_MONTH)))
		{
			//retira-se um ano à idade:
			age--;
			
		}



		return age;
	}

	public String toString()
	{
		return nome + ", " + idade() + " anos de idade, do sexo "
		+ sexo + ", " + profissão + ", telefone n.º " + telefone
		+ ", e-mail: " + email;
	}
}
