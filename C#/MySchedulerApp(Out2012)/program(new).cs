using System;
	using System.Collections.Generic;
	using System.Linq;
	using System.Text;
	using ConsoleApplication1.XMPieAPIWS_JobTicket;
using ConsoleApplication1.XMPieAPIWS_Production;

	namespace ConsoleApplication1
	{
		class Program
		{
			static void Main(string[] args)
			{
				foreach (string docID in args)
				SendToProcess(docID);
			}
			static void SendToProcess(string docID)
			{
                string uName = "admin";
				string Password = "admin";
				string DocumentID = docID;

				// Create the job ticket web service object
				//XMPieAPIWS_JobTicket.JobTicket_SSP jobTicketWS = new XMPieAPIWS_JobTicket.JobTicket_SSP();
                JobTicket_SSP jobTicketWS = new JobTicket_SSP(); 


				// Create a new job ticket
				//string jobTicketID = jobTicketWS.CreateNewTicketForDocument(uName, 	Password,	DocumentID, "",	false);
                string jobTicketID = jobTicketWS.CreateNewTicketForDocument(uName, Password, DocumentID, "", false); 

                //-----------------------------------------------------------------------------------------------------------------------------------------

                jobTicketWS.SetOutputInfo(uName,Password,jobTicketID,"PDF",1, "", "",null); 

				// Set the job output type
				//jobTicketWS.SetOutputInfo(uName,Password,jobTicketID,"PDFO",1, "", "",null);
                // Set the job type
				//jobTicketWS.SetJobType(uName,Password,jobTicketID, "PRINT");

                // Set the job type 
                jobTicketWS.SetJobType(uName,Password,jobTicketID, "PRINT");

                jobTicketWS.SetRIRange(uName, Password, jobTicketID, 3, 3);

                //-----------------------------------------------------------------------------------------------------------------------------------------

				// Create the production web service object
				//XMPieAPIWS_Production.Production_SSP productionWS =	new XMPieAPIWS_Production.Production_SSP();
                Production_SSP productionWS = new Production_SSP(); 



                // Submit the job
				//string jobID = productionWS.SubmitJob(uName,Password,jobTicketID, 0 , "");
                string jobID = productionWS.SubmitJob(uName,Password,jobTicketID, "0", ""); 


				Console.WriteLine( "Job " + jobID + " is being submitted.");
			}
		}
	}