namespace LMSService.Infrastructure.Connectors.Interfaces
{
    public interface ILMSConnector
    {
        Task<HttpResponseMessage> GetAsync(string url);
        Task<HttpResponseMessage> PostAsync<T>(string url, T body);
        Task<HttpResponseMessage> PutAsync<T>(string url, T body);
        Task<HttpResponseMessage> DeleteAsync(string url);
    }
}
