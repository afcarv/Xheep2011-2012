package Ficha8;

import java.util.Date;
import java.util.Calendar;

public class Contacto {
	public String nome;
	//date j� que desta forma facilmente se faz a convers�o de string para date e vice versa
	public Date aniversario;
	public String sexo;
	public String profiss�o;
	public String telefone;
	public String email;

	public Contacto()
	{
		nome = "";
		//inicializa��o:
		aniversario = null;
		sexo = "";
		profiss�o = "";
		telefone = "";
		email = "";
	}

	Contacto(String _nome, Date _aniversario, String _sexo, String _profiss�o, String _telefone, String _email)
	{
		this();

		nome = _nome;
		aniversario = _aniversario;
		sexo = _sexo;
		profiss�o = _profiss�o;
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

		//c�lculo da idade:
		int age = today.get(Calendar.YEAR) - bday.get(Calendar.YEAR);

		//para o caso de fazer anos ap�s a data actual
		if((bday.get(Calendar.MONTH) > today.get(Calendar.MONTH)) || (bday.get(Calendar.MONTH) == today.get(Calendar.MONTH) && 
				bday.get(Calendar.DAY_OF_MONTH) > today.get(Calendar.DAY_OF_MONTH)))
		{
			//retira-se um ano � idade:
			age--;
			
		}



		return age;
	}

	public String toString()
	{
		return nome + ", " + idade() + " anos de idade, do sexo "
		+ sexo + ", " + profiss�o + ", telefone n.� " + telefone
		+ ", e-mail: " + email;
	}
}
