using LMSService.Infrastructure.Connectors.Abstracts;

namespace LMSService.Infrastructure.Connectors.Concretes
{
    public class LMSConector : AbstractLMSConector
    {
        public LMSConector(HttpClient client) : base(client)
        {
        }
    }
}
