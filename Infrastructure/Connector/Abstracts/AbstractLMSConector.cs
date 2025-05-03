using System.Text;
using System.Text.Json;
using LMSService.Infrastructure.Connectors.Interfaces;

namespace LMSService.Infrastructure.Connectors.Abstracts
{
    public abstract class AbstractLMSConector(HttpClient client) : ILMSConnector
    {
        private readonly HttpClient _client = client;

        public async Task<HttpResponseMessage> GetAsync(string url)
        {
            return await _client.GetAsync(url);
        }

        public async Task<HttpResponseMessage> PostAsync<T>(string url, T body)
        {
            var json = JsonSerializer.Serialize(body);
            var content = new StringContent(json, Encoding.UTF8, "application/json");
            return await _client.PostAsync(url, content);
        }

        public async Task<HttpResponseMessage> PutAsync<T>(string url, T body)
        {
            var json = JsonSerializer.Serialize(body);
            var content = new StringContent(json, Encoding.UTF8, "application/json");
            return await _client.PutAsync(url, content);
        }

        public async Task<HttpResponseMessage> DeleteAsync(string url)
        {
            return await _client.DeleteAsync(url);
        }
    }
}
