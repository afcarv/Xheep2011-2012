import java.util.Calendar;

public class Contacto {
	public String nome;
	public Calendar aniversario;
	public String sexo;
	public String profissão;
	public String telefone;
	public String email;
	
	Contacto(String _nome, Calendar _aniversario, String _sexo, String _profissão, String _telefone, String _email)
	{
		nome = _nome;
		aniversario = _aniversario;
		sexo = _sexo;
		profissão = _profissão;
		telefone = _telefone;
		email = _email;
	}
	
	public int idade()
	{
		// http://www.exampledepot.com/egs/java.util/GetAge.html
		Calendar today = Calendar.getInstance();
		Calendar bday = (Calendar)aniversario.clone();
		
		int age = today.get(Calendar.YEAR) - aniversario.get(Calendar.YEAR);
		bday.add(Calendar.YEAR, age);
		if (today.before(bday)) age--;
		
		return age;
	}
	
	public String toString()
	{
		return nome + ", " + idade() + " anos de idade, do sexo "
			+ sexo + ", " + profissão + ", telefone n.º " + telefone
			+ ", e-mail: " + email;
	}
}
